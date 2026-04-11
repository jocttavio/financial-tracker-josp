<?php

namespace App\Http\Expense;

use App\Http\Controllers\BaseController;
use App\Http\Expense\Requests\SaveExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpenseController extends BaseController
{
  private ExpenseValidations $validations;

  public function __construct(ExpenseValidations $validations)
  {
    $this->validations = $validations;
  }

  public function index()
  {
    $expenses = Expense::with('category', 'productService')->get();
    return $this->sendResponse($expenses, 'Expenses retrieved successfully');
  }

  public function store(SaveExpenseRequest $request)
  {
    Log::info('Attempting to create a new revenue record.', ['request_data' => $request->all()]);
    $data = $request->validated();
    Log::info('Validated data for creating expense record.', ['validated_data' => $data]);
    $expense = DB::transaction(function () use ($data) {
      $expense = Expense::create([
        'amount' => $data['amount'],
        'description' => $data['description'],
        'date' => $data['date'],
        'category_id' => $data['id_category'],
        'product_service_id' => $data['id_product_service'],
        'payment_method' => $data['payment_method'],
      ]);

      return $expense;
    });
    return $this->sendResponse($expense, 'Expense created successfully');
  }

  public function summary()
  {
    $totalExpenses = Expense::sum('amount');
    return $this->sendResponse(['total_expenses' => $totalExpenses], 'Summary retrieved successfully');
  }
}
