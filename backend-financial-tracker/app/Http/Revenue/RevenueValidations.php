<?php

namespace App\Http\Revenue;
use App\Exceptions\CustomError;
use Illuminate\Database\DatabaseManager;
class RevenueValidations
{

   private DatabaseManager $db;

   public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }


}