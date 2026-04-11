
import { formatDate } from '@/app/utils/date';
import React from 'react'

type ExpenseItem = {
  id_expense: number;
  date: string;
  description: string;
  amount: string;
  category?:{name: string};
  payment_method: string;
  product_service?:{name: string} | null;
};  

const ExpensesTable = async() => {
   const baseUrl = process.env.BACKEND_URL; // ej: http://127.0.0.1:4000
  if (!baseUrl) {
    throw new Error("Missing BACKEND_URL in environment variables");
  }
  let data: ExpenseItem[] = [];
  
    try {
      const response = await fetch(`${baseUrl}/expenses`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
         cache: "no-store", // evita caché si quieres datos siempre frescos
         credentials: "include", // para enviar cookies si es necesario
        });
        if (!response.ok) {
          throw new Error(`HTTP ${response.status}`);
        }
        const payload: { success: boolean; data: ExpenseItem[]; message?: string } =
        await response.json();
        
        console.log('response->', payload.data);
        
        data = Array.isArray(payload.data) ? payload.data : [];
  
    } catch (error: Error | unknown) {
      console.log("Error fetching data:", error);
    }

  return (
 <div>
      <h2 className="text-2xl font-bold mb-4">Financial Data Table</h2>
      <table className="min-w-full bg-white border border-gray-200">
        <thead>
          <tr>
            <th className="py-2 px-4 border-b">Date</th>
            <th className="py-2 px-4 border-b">Description</th>
            <th className="py-2 px-4 border-b">Amount</th>
            <th className="py-2 px-4 border-b">Category</th>
            <th className="py-2 px-4 border-b">Payment Method</th>
            <th className="py-2 px-4 border-b">Product/Service</th>
          </tr>
        </thead>
        <tbody>
          {/* Sample data rows */}
          {data.length > 0 ? data.map((item, index) => (
            <tr key={index}>
              <td className="py-2 px-4 border-b">{formatDate(item.date)}</td>
              <td className="py-2 px-4 border-b">{item.description}</td>
              <td className="py-2 px-4 border-b">{item.amount}</td>
              <td className="py-2 px-4 border-b">{item.category?.name || 'No Category'}  </td>
              <td className="py-2 px-4 border-b">{item.payment_method || 'No Payment Method'}</td>
              <td className="py-2 px-4 border-b">{item.product_service?.name || 'No Product/Service'}</td>
            </tr>
          )): (
            <tr>
              <td className="py-2 px-4 border-b text-center" colSpan={5}>No data available</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  )
}

export default ExpensesTable