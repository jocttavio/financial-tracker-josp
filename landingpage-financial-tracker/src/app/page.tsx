import CategoryForm from "./components/CategoryForm";
import Navbar from "./components/layouts/Navbar";
import ProductServicesForm from "./components/ProductServicesForm";

export default function Home() {
  return (
    <div className="flex flex-col items-center justify-center ">
      <Navbar />
      <section className="min-h-90 flex flex-col items-center justify-center gap-4 mt-4">
      <CategoryForm />
      <ProductServicesForm />
      </section>
    </div>
  );
}
