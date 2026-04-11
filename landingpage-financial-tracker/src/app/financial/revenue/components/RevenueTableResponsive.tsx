'use client'
import React from 'react'
import RevenueCard from './RevenueCard';
import customApi from "@/app/client/custom_api";

type RevenueItem = {
  id_revenue: number;
  date: string;
  description: string;
  amount: string;
  category?:{name: string};
};

const RevenueTableResponsive = () => {
  const api = customApi();
  const [data, setData] = React.useState<RevenueItem[]>([]);
  React.useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await api.get('/revenue');
         const payload: { success: boolean; data: RevenueItem[]; message?: string } =
        await response.data;
        
        console.log(response.data);
        setData(payload.data);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    };
    
    fetchData();
  }, []);
  return (
    <div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4'>
      {data.map((item: RevenueItem, index: number) => (
        <RevenueCard key={index} item={item} />
      ))}
    </div>
  )
}

export default RevenueTableResponsive