

export default function CategoryForm() {
  return (
    <div className="flex flex-col items-center justify-center  font-sans ">
      <h1 className="text-3xl font-bold text-zinc-900 dark:text-zinc-50">Category Form</h1>
      <form className="flex flex-col items-center justify-center mt-4">
        <input
          type="text"
          placeholder="Category Name"
          className="border border-zinc-300 rounded-md px-4 py-2 mb-4 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-zinc-50"
        />
        <input
          type="text"
          placeholder="Category Description"
          className="border border-zinc-300 rounded-md px-4 py-2 mb-4 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-zinc-50"
        />
        <button
          type="submit"
          className="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Add Category
        </button>
      </form>
    </div>
  );
}