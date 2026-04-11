<?php

namespace App\Http\Expense;
use App\Exceptions\CustomError;
use Illuminate\Database\DatabaseManager;
class ExpenseValidations
{

   private DatabaseManager $db;

   public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }


}