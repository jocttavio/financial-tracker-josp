import React from 'react'

type RevenueItem = {
  id_revenue: number;
  date: string;
  description: string;
  amount: string;
  category?:{name: string};
};


const RevenueCard = ({ item }: { item: RevenueItem }) => {
  return (
    <div className='border-2 border-gray-100 p-2 rounded-md grid grid-cols-2 gap-2 min-w-87.5'>
      <div className='border-r-2 border-r-amber-200 bg-amber-100 rounded-md flex items-center justify-center relative'>
        <h1>{item.category?.name || 'Uncategorized'}</h1>
        <h2 className='absolute top-0 left-0 pl-2 pt-1 text-blue-500'>{item.id_revenue}</h2>
      </div>
      <div className='flex flex-col'>
        <div className='font-bold text-2xl text-green-500'>${item.amount ? item.amount : '0.00'}</div>
        <div>
          <p className='text-sm font-light text-gray-500'>
            {item.description}
          </p>
          </div>
      </div>
    </div>
  )
}

export default RevenueCard