import React from 'react'
import ExpensesTable from './components/ExpensesTable'
import { Button } from "@/components/ui/button"
import ExpensesCreate from './components/ExpensesCreate'
const Expenses = () => {
  return (
    <div className='flex flex-col items-center justify-center md:p-4 mx-auto'>
      <h1 className='text-3xl font-bold mb-4'>Expenses</h1>
      <div className='flex justify-center mt-4'>
      <ExpensesCreate />
      </div>
      <ExpensesTable />
    </div>
  )
}

export default Expenses