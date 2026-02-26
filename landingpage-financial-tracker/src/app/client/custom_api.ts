"use client";
import axios from "axios";

export default function customApi() {
  try {
    if (typeof window !== "undefined") {
      const hostname = process.env.NEXT_PUBLIC_HOSTNAME_BACKEND;
      let api = axios.create({
        baseURL: `${hostname}`,
        withCredentials: true,
      });
      return api;
    }
  } catch (error) {
    console.log(error);
  }
}
