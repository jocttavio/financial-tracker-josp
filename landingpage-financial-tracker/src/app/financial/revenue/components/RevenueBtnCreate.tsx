"use client";
import React from "react";
import RevenueCreate from "./RevenueCreate";

export default function RevenueBtnCreate() {
  const [isModalOpen, setIsModalOpen] = React.useState(false);
  const handleClick = () => {
    setIsModalOpen(true);
  };
  return (
    <section>
      <button
        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        onClick={() => setIsModalOpen(true)}
      >
        Add Revenue
      </button>
      <RevenueCreate isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
    </section>
  );
}
