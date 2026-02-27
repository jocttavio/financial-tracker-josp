//! In this moment the table fetching data here

type RevenueItem = {
  date: string;
  description: string;
  amount: number;
  category?: { name?: string };
};

export default async function Table (){
  const baseUrl = process.env.BACKEND_URL; // ej: http://127.0.0.1:4000
  if (!baseUrl) {
    throw new Error("Missing BACKEND_URL in environment variables");
  }
  let data: RevenueItem[] = [];
console.log(baseUrl);
  
    try {
      const response = await fetch(`${baseUrl}/revenue`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
         cache: "no-store", // evita caché si quieres datos siempre frescos
         credentials: "include", // para enviar cookies si es necesario
      });
      console.log('response->', response);
        if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }
    const payload: { success: boolean; data: RevenueItem[]; message?: string } =
      await response.json();

    data = Array.isArray(payload.data) ? payload.data : [];
  
    } catch (error: Error | unknown) {
      console.log("Error fetching data:", error);
    }

  return (
    <div>
      <h2 className="text-2xl font-bold mb-4">Financial Data Table</h2>
      <table className="min-w-full bg-white border border-gray-200">
        <thead>
          <tr>
            <th className="py-2 px-4 border-b">Date</th>
            <th className="py-2 px-4 border-b">Description</th>
            <th className="py-2 px-4 border-b">Amount</th>
            <th className="py-2 px-4 border-b">Category</th>
          </tr>
        </thead>
        <tbody>
          {/* Sample data rows */}
          {data.map((item, index) => (
            <tr key={index}>
              <td className="py-2 px-4 border-b">{item.date}</td>
              <td className="py-2 px-4 border-b">{item.description}</td>
              <td className="py-2 px-4 border-b">{item.amount}</td>
              <td className="py-2 px-4 border-b">{item.category?.name || 'No Category'}  </td>
          </tr>))}
        </tbody>
      </table>
    </div>
  );
}