'use client';
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

import React from "react";
import customApi from "@/app/client/custom_api";
import { toast } from "sonner";




const ExpensesCreate = () => {
  const api = customApi();

  const [formExpense, setFormExpense] = React.useState({
    description: "",
    amount: 0,
    date: "",
    id_category: "",
    payment_method: "",
    id_product_service: "",
  });
  const [listOptions, setListOptions] = React.useState({
    categories: [] as { name: string; id_category: number }[],
    paymentMethods: [] as string[],
    productsServices: [] as { name: string; id_product_service: number }[],
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormExpense((prev) => ({ ...prev, [name]: value }));
  };

  const handleSelectChange = (name: string, value: string) => {
    setFormExpense((prev) => ({ ...prev, [name]: value }));
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const result = await api.post("/expenses/create", formExpense);
      if(result.data.success) {
        toast.success("Expense created successfully!",{ position: "top-center" });
      setFormExpense({
        description: "",
        amount: 0,
        date: "",
        id_category: "",
        payment_method: "",
        id_product_service: "",
      });  
    }
      // Optionally, you can reset the form or show a success message here
    } catch (error) {
      console.error("Error creating expense:", error);
      // Optionally, show an error message to the user
    }
  }

  React.useEffect(() => {
      // Fetch categories, payment methods, and products/services if needed
      async function fetchData() {
        try {
          const { data: categoriesData } = await api.get("/default/categories");
        const { data: productServicesData } = await api.get("/default/products-services");
        const { data: paymentMethodsData } = await api.get("/default/payment-methods");
        console.log(categoriesData.data);
        console.log(productServicesData.data);
        console.log(paymentMethodsData.data);
        // You can set these to state if you want to populate select options
        setListOptions({
          categories: categoriesData.data,
          paymentMethods: paymentMethodsData.data,
          productsServices: productServicesData.data,
        });

        } catch (error) {
          console.error("Error fetching data:", error);
        }
      }

      fetchData();
  }, []);


  return (
    <Dialog>
      <form >
        <DialogTrigger asChild>
          <Button variant="outline">Add Expense</Button>
        </DialogTrigger>
        <DialogContent className="sm:max-w-sm">
          <DialogHeader>
            <DialogTitle>Create Expense</DialogTitle>
            <DialogDescription>
              Fill in the details for the new expense.
            </DialogDescription>
          </DialogHeader>
          <FieldGroup>
            <Field>
              <Label htmlFor="description">Description</Label>
              <Input id="description" name="description" value={formExpense.description} onChange={handleChange} />
            </Field>
            <Field>
              <Label htmlFor="amount">Amount</Label>
              <Input id="amount" name="amount" type="number" value={formExpense.amount} onChange={handleChange} />
            </Field>
            <Field>
              <Label htmlFor="date">Date</Label>
              <Input id="date" name="date" type="date" value={formExpense.date} onChange={handleChange} />
            </Field>
            <Field>
              <Label htmlFor="category">Category</Label>
              <Select onValueChange={(value: string) => handleSelectChange("id_category", value)}>
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
              <Label htmlFor="payment_method">Payment Method</Label>
              <Select onValueChange={(value: string) => handleSelectChange("payment_method", value)}>
                <SelectTrigger className="w-full max-w-48">
                  <SelectValue placeholder="Select a payment method" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Methods</SelectLabel>
                    {listOptions.paymentMethods.map((method) => (
                      <SelectItem key={method} value={method}>
                        {method}
                      </SelectItem>
                    ))}
                  </SelectGroup>
                </SelectContent>
              </Select>
            </Field>
            <Field>
              <Label htmlFor="product_service">Product/Service</Label>
              <Select onValueChange={(value: string) => handleSelectChange("id_product_service", value)}>
                <SelectTrigger className="w-full max-w-48">
                  <SelectValue placeholder="Select a product or service" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Products/Services</SelectLabel>
                    {listOptions.productsServices.map((ps) => (
                      <SelectItem key={ps.id_product_service} value={ps.id_product_service}>
                        {ps.name}
                      </SelectItem>
                    ))}
                  </SelectGroup>
                </SelectContent>
              </Select>
            </Field>
            <Field>
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
};

export default ExpensesCreate;
