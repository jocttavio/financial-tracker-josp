'use client'
import React from "react";
import customApi from "../client/custom_api";
export default function ProductServicesForm() {
  const api = customApi();
  const [formData, setFormData] = React.useState({
    name: '',
    description: '',
  });
  
  const handleSubmit = async(e: React.FormEvent) => {
  e.preventDefault();
  
  const {data}= await api.post('/default/products-services/create', {
    name: formData.name,
    description: formData.description,
  });
  
  // fetch('http://localhost:8000/api/default/products-services/create', {
  //   method: 'POST',
  //   credentials: 'include',
  //   headers: {
  //     'Content-Type': 'application/json',
  //   },
  //   body: JSON.stringify({
  //     name: formData.name,
  //     description: formData.description,
  //   }),
  // });
  console.log(data);

  if (data.success) {
    console.log('Product/Service added successfully!');
  } else {
    console.error('Failed to add Product/Service.');
  }
}

const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
  const { name, value } = e.target;
  setFormData(prev => ({ ...prev, [name]: value }));
}
  return (
    <div className="flex flex-col items-center justify-center ">
      <h1 className="text-3xl font-bold text-zinc-900 dark:text-zinc-50">Product/Services Form</h1>
      <form className="flex flex-col items-center justify-center mt-4"
      >
        <input
          type="text"
          name="name"
          onChange={handleInputChange}
          placeholder="Product/Service Name"
          className="border border-zinc-300 rounded-md px-4 py-2 mb-4 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-zinc-50"
        />
        <input
          type="text"
          name="description"
          onChange={handleInputChange}
          placeholder="Product/Service Description"
          className="border border-zinc-300 rounded-md px-4 py-2 mb-4 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-zinc-50"
        />
        <button
        type="button"
        onClick={handleSubmit}
          className="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Add Product/Service
        </button>
      </form>
    </div>
  );
}