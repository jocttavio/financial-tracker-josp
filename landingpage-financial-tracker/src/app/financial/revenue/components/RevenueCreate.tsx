"use client";
import React from "react";
import customApi from "@/app/client/custom_api";
import { useEffect, useState } from "react";
import { Button } from "@/components/ui/button";
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import {
  FieldLabel,
  FieldGroup,
  Field,
  FieldError,
  FieldDescription,
} from "@/components/ui/field";

import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

import { toast } from "sonner";

function RevenueCreate() {
  const [formRevenue, setFormRevenue] = useState({
    description: "",
    amount: "",
    date: "",
    id_category: 0,
  });
  const [listOptions, setListOptions] = React.useState({
    categories: [] as { name: string; id_category: number }[],
    accounts: [] as { name: string; id_account: number }[],
  });

  const api = customApi();
  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormRevenue((prev) => ({ ...prev, [name]: value }));
  };

  const handleSelectChange = (name: string, value: string) => {
    setFormRevenue((prev) => ({ ...prev, [name]: value }));
  };

  useEffect(() => {
    const fetchCategories = async () => {
      try {
        const { data: categoriesData } = await api.get("/default/categories");
        const { data: accountsData } = await api.get("/default/accounts");
        console.log(categoriesData.data);
        console.log(accountsData.data);
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

        if (payload.success && payloadAccounts.success) {
          setListOptions({
            categories: Array.isArray(payload.data) ? payload.data : [],
            accounts: Array.isArray(payloadAccounts.data)
              ? payloadAccounts.data
              : [],
          });
        } else {
          toast.error("Failed to fetch categories or accounts", {
            position: "top-center",
          });
        }
      } catch (error) {
        console.error("Error fetching categories:", error);
        toast.error("An error occurred while fetching categories or accounts", {
          position: "top-center",
        });
      }
    };
    fetchCategories();
  }, []);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const response = await api.post("/revenue/create", formRevenue);
      console.log(response);
      if (response.data.success) {
        toast.success("Revenue created successfully!", {
          position: "top-center",
        });
      }else{
        toast.error("Failed to create revenue: " + response.data.message, {
          position: "top-center",
        });
      }

      setFormRevenue({
        description: "",
        amount: "",
        date: "",
        id_category: 0,
      });

    } catch (error) {
      console.error("Error creating revenue:", error);
      toast.error("An error occurred while creating revenue", {
        position: "top-center",
      });
    }
  };

  return (
    <Dialog>
      <form>
        <DialogTrigger asChild>
          <Button variant="outline" size="lg">
            Add Revenue
          </Button>
        </DialogTrigger>
        <DialogContent className="sm:max-w-sm">
          <DialogHeader>
            <DialogTitle>Create Revenue</DialogTitle>
            <DialogDescription>
              Fill in the details for the new revenue.
            </DialogDescription>
          </DialogHeader>
          <FieldGroup>
            <Field>
              <Label htmlFor="description">Description</Label>
              <Input
                id="description"
                name="description"
                value={formRevenue.description}
                onChange={handleChange}
              />
            </Field>
            <Field>
              <Label htmlFor="amount">Amount</Label>
              <Input
                id="amount"
                name="amount"
                type="number"
                value={formRevenue.amount}
                onChange={handleChange}
              />
            </Field>
            <Field>
              <Label htmlFor="date">Date</Label>
              <Input
                id="date"
                name="date"
                type="date"
                value={formRevenue.date}
                onChange={handleChange}
              />
            </Field>
            <Field>
              <Label htmlFor="category">Category</Label>
              <Select
                onValueChange={(value: string) =>
                  handleSelectChange("id_category", value)
                }
              >
                <SelectTrigger className="w-full max-w-48">
                  <SelectValue placeholder="Select a category" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Categories</SelectLabel>
                    {listOptions.categories.map((cat) => (
                      <SelectItem key={cat.id_category} value={cat.id_category}>
                        {cat.name}
                      </SelectItem>
                    ))}
                  </SelectGroup>
                </SelectContent>
              </Select>
            </Field>
            
            <Field>
              <Label htmlFor="account">Account</Label>
              <Select
                onValueChange={(value: string) =>
                  handleSelectChange("id_account", value)
                }
              >
                <SelectTrigger className="w-full max-w-48">
                  <SelectValue placeholder="Select an account" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Accounts</SelectLabel>
                    {listOptions.accounts.map((account) => (
                      <SelectItem key={account.id_account} value={account.id_account}>
                        {account.name}
                      </SelectItem>
                    ))}
                  </SelectGroup>
                </SelectContent>
              </Select>
            </Field>
          </FieldGroup>
          <DialogFooter>
            <DialogClose asChild>
              <Button variant="outline">Cancel</Button>
            </DialogClose>
            <Button type="submit" onClick={handleSubmit}>
              Save changes
            </Button>
          </DialogFooter>
        </DialogContent>
      </form>
    </Dialog>
  );
}


export default RevenueCreate;