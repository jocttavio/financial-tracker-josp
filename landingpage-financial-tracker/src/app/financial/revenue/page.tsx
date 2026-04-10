import RevenueTable from "./components/RevenueTable";
import RevenueCreate from "./components/RevenueCreate";
import RevenueBtnCreate from "./components/RevenueBtnCreate";
import RevenueSummary from "./components/RevenueSummary";
export default function Revenue() {
  return (
    <div className="flex flex-col items-center justify-center md:p-4">
      <h1 className="text-3xl font-bold my-4 text-start">Revenue Page</h1>
      <section>
        <div className="flex justify-end">
        <RevenueBtnCreate />
        </div>
        <div className="my-4">
        <RevenueSummary />
        </div>
        <RevenueTable />
      </section>
    </div>
  );
}
