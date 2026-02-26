


export default function Navbar() {
  return (
    <nav className="bg-blue-500 text-white px-4 py-2 rounded-md ">
      <div className="container mx-auto flex items-center justify-between gap-4">
        <h1 className="text-xl font-bold">Financial Tracker</h1>
        <div>
          <button className="px-3 py-2 rounded-md hover:bg-blue-600 cursor-pointer">
            Ingresos
          </button>
          <button className="px-3 py-2 rounded-md hover:bg-blue-600 cursor-pointer">
            Egresos
          </button>
        </div>
      </div>
    </nav>
  );
}