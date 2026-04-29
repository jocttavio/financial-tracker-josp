"use client";
import React from "react";
import RevenueCreate from "./RevenueCreate";
import { Button } from "@/components/ui/button";
export default function RevenueBtnCreate() {
  const [isModalOpen, setIsModalOpen] = React.useState(false);
  const handleClick = () => {
    setIsModalOpen(true);
  };
  return (
    <section>
      <Button
        variant="outline"
        size="lg"
        
        onClick={() => setIsModalOpen(true)}
      >
        Add Revenue
      </Button>
      <RevenueCreate isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
    </section>
  );
}
