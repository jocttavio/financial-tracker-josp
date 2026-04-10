'use client'
import React from 'react'
import { useEffect, useState } from "react";
import customApi from "@/app/client/custom_api";

const RevenueSummary= () => {
  const api = customApi();

  const [summary, setSummary] = useState({
    total_revenue: 0,
    total_entries: 0,
    average_revenue: 0,
    current_month_revenue: 0,
    current_month_entries: 0,
  });

  useEffect(() => {
    const fetchSummary = async () => {
      try {
        const response = await api.get('/revenue/summary');
        console.log(response.data.data);
        setSummary(response.data.data);
      } catch (error) {
        console.error('Error fetching revenue summary:', error);
      }
    };

    fetchSummary();
  }, []);
  return (
    <div>
      <h1>Revenue Resume</h1>
      <section className='grid grid-cols-1 md:grid-cols-4 border-2 border-gray-300 rounded-lg p-4 gap-4'>
        <div className='p-2'>
          <h2 className='font-bold'>Total ingresos</h2>
          <div>
            <p>${summary.total_revenue || '0.00'}</p>
          </div>
        </div>
        <div className='p-2'>
          <h2 className='font-bold'>Total movimientos</h2>
          <div>
            <p>{summary?.total_entries ? summary.total_entries : 0}</p>
          </div>
        </div>
        <div className='p-2'>
          <h2 className='font-bold'>Promedio ingresos</h2>
          <div>
            <p>${summary?.average_revenue?.toFixed(2) || '0.00'}</p>
          </div>
        </div>
        <div className='p-2'>
          <h2 className='font-bold'>Ingresos del mes actual</h2>
          <div>
            <p>${summary?.current_month_revenue || '0.00'}</p>
          </div>
        </div>
      </section>
    </div>
  )
}

export default RevenueSummary