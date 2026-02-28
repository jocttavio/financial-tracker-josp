"use client";
import React from "react";
import customApi from "@/app/client/custom_api";
import { useEffect, useState } from "react";
export default function RevenueCreate({
  isOpen,
  onClose,
}: {
  isOpen: boolean;
  onClose: () => void;
}) {
  const [shouldRender, setShouldRender] = useState(isOpen);
  const [visible, setVisible] = useState(false);
  const [formData, setFormData] = useState({
    description: "",
    amount: "",
    date: "",
    id_category: 0,
  });
  const [listCategories, setListCategories] = useState<
    { name: string; id_category: number }[]
  >([]);
  const [listAccounts, setListAccounts] = useState<
    { name: string; id_account: number }[]
  >([]);
  const baseUrl = process.env.BACKEND_URL; // ej: http://
  const api = customApi();
  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleCategoryChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleAccountChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  useEffect(() => {
    let timeoutId: ReturnType<typeof setTimeout> | undefined;
    let raf1: number | undefined;
    let raf2: number | undefined;

    const fetchCategories = async () => {
      try {
        const { data: categoriesData } = await api.get("/default/categories");
        const { data: accountsData } = await api.get("/default/accounts");
        console.log(categoriesData.data);
        console.log(accountsData.data);
        setListCategories(Array.isArray(categoriesData.data) ? categoriesData.data : []);
        setListAccounts(Array.isArray(accountsData.data) ? accountsData.data : []); 
        const payload: {
          success: boolean;
          data: {
            name: string;
            description: string;
            id_category: number;
            created_at: string;
          }[];
          message?: string;
        } = categoriesData;
        setListCategories(Array.isArray(payload.data) ? payload.data : []);

        const payloadAccounts: {
          success: boolean;
          data: {
            name: string;
            type: string;
            current_balance: number;
            id_account: number;
            created_at: string;
          }[];
          message?: string;
        } = accountsData;
        setListAccounts(Array.isArray(payloadAccounts.data) ? payloadAccounts.data : []);
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    };

    if (isOpen) {
      fetchCategories();
      setShouldRender(true);
      setVisible(false); // estado inicial para animar entrada
      raf1 = requestAnimationFrame(() => {
        raf2 = requestAnimationFrame(() => {
          setVisible(true); // ahora sí anima al abrir
        });
      });
    } else {
      setVisible(false); // anima salida
      timeoutId = setTimeout(() => setShouldRender(false), 200);
    }

    return () => {
      if (timeoutId) clearTimeout(timeoutId);
      if (raf1) cancelAnimationFrame(raf1);
      if (raf2) cancelAnimationFrame(raf2);
    };
  }, [isOpen]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const response = await api.post("/revenue/create", formData);
      console.log(response);
      if (response.data.success) {
        alert("Revenue created successfully!");
        onClose(); // Cierra el modal después de enviar
      }
    } catch (error) {
      console.error("Error creating revenue:", error);
    }
  };

  if (!shouldRender) return null;

  return (
    <div
      className={`fixed inset-0 z-50 flex items-center justify-center bg-black/50 transition-opacity duration-200 ${
        visible ? "opacity-100" : "opacity-0"
      }`}
      onClick={onClose}
    >
      <div
        className={`bg-white p-6 rounded-md w-full max-w-md transform transition-all duration-200 ${
          visible
            ? "opacity-100 scale-100 translate-y-0"
            : "opacity-0 scale-95 translate-y-2"
        }`}
        onClick={(e) => e.stopPropagation()}
      >
        <h2 className="text-2xl font-bold mb-4">Add Revenue</h2>
        <form onSubmit={handleSubmit}>
          <input
            type="text"
            name="description"
            id="description"
            placeholder="Description"
            className="w-full p-2 border border-gray-300 rounded mb-4"
            onChange={handleChange}
          />
          <input
            type="number"
            name="amount"
            id="amount"
            placeholder="Amount"
            className="w-full p-2 border border-gray-300 rounded mb-4"
            onChange={handleChange}
          />
          <input
            type="date"
            name="date"
            id="date"
            className="w-full p-2 border border-gray-300 rounded mb-4"
            onChange={handleChange}
          />
          <select
            name="id_category"
            id="category"
            onChange={handleCategoryChange}
            className="w-full p-2 border border-gray-300 rounded mb-4"
          >
            <option value="">Select Category</option>
            {listCategories.map((cat, index) => (
              <option key={index} value={cat.id_category}>
                {cat.name}
              </option>
            ))}
          </select>

          <select
            name="id_account"
            id="account"
            onChange={handleAccountChange}
            className="w-full p-2 border border-gray-300 rounded mb-4"
          >
            <option value="">Select Account</option>
            {listAccounts.map((acc, index) => (
              <option key={index} value={acc.id_account}>
                {acc.name}
              </option>
            ))}
          </select>

          <div className="flex justify-end">
            <button
              type="button"
              className="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400"
              onClick={onClose}
            >
              Cancel
            </button>
            <button
              type="submit"
              className="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
            >
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
