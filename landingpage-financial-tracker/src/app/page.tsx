import CategoryForm from "./components/CategoryForm";
import ProductServicesForm from "./components/ProductServicesForm";

export default function Home() {
  return (
    <div className="flex flex-col items-center justify-center ">
      <h1 className="text-3xl font-bold mt-4">Financial Tracker</h1>
      <section className="min-h-90 flex flex-col items-center justify-center gap-4 mt-4">
      
      <ProductServicesForm />
      </section>
    </div>
  );
}
