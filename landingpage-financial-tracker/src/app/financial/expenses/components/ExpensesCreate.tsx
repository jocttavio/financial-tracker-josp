
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

const ExpensesCreate = () => {

  const URL_BACKEND = process.env.NEXT_PUBLIC_HOSTNAME_BACKEND +"/expenses/create";

  return (
    <Dialog>
      <form method="POST" 
      action={URL_BACKEND}
      className="w-full"
      encType="multipart/form-data" 
      >
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
              <Input id="description" name="description" />
            </Field>
            <Field>
              <Label htmlFor="amount">Amount</Label>
              <Input id="amount" name="amount" type="number" />
            </Field>
            <Field>
              <Label htmlFor="date">Date</Label>
              <Input id="date" name="date" type="date" />
            </Field>
            <Field>
              <Label htmlFor="category">Category</Label>
              <Select>
                <SelectTrigger className="w-full max-w-48">
                  <SelectValue placeholder="Select a category" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Categories</SelectLabel>
                    <SelectItem value="food">Food</SelectItem>
                    <SelectItem value="transport">Transport</SelectItem>
                    <SelectItem value="entertainment">Entertainment</SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
            </Field>
            <Field>
              <Label htmlFor="payment_method">Payment Method</Label>
              <Select>
                <SelectTrigger className="w-full max-w-48">
                  <SelectValue placeholder="Select a payment method" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Methods</SelectLabel>
                    <SelectItem value="credit">Credit Card</SelectItem>
                    <SelectItem value="debit">Debit Card</SelectItem>
                    <SelectItem value="cash">Cash</SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
            </Field>
            <Field>
              <Label htmlFor="product_service">Product/Service</Label>
              <Select>
                <SelectTrigger className="w-full max-w-48">
                  <SelectValue placeholder="Select a product or service" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Products/Services</SelectLabel>
                    <SelectItem value="luz">Luz</SelectItem>
                    <SelectItem value="internet">Internet</SelectItem>
                    <SelectItem value="gas">Gas</SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
            </Field>
            <Field>
              {/* <Input type="hidden" name="csrf" value={csrfToken} /> */}
            </Field>
          </FieldGroup>
          <DialogFooter>
            <DialogClose asChild>
              <Button variant="outline">Cancel</Button>
            </DialogClose>
            <Button type="submit">Save changes</Button>
          </DialogFooter>
        </DialogContent>
      </form>
    </Dialog>
  );
};

export default ExpensesCreate;
