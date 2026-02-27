import RevenueTable from "./components/RevenueTable";
import RevenueCreate from "./components/RevenueCreate";
import RevenueBtnCreate from "./components/RevenueBtnCreate";
export default function Revenue() {
  return (
    <div className="flex flex-col items-center justify-center md:p-4">
      <h1 className="text-3xl font-bold mt-4 text-start">Revenue Page</h1>
      <section>
        <RevenueBtnCreate />
        <RevenueTable />
      </section>
    </div>
  );
}
