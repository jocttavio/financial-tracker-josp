<?php

namespace App\Http\Revenue;

use App\Http\Controllers\BaseController;
use App\Http\Revenue\Requests\SaveRevenueRequest;
use App\Http\Revenue\RevenueValidations;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RevenueController extends BaseController
{

    private RevenueValidations $validations;

    public function __construct(RevenueValidations $validations)
    {
        $this->validations = $validations;
    }

    public function index(Request $request)
    {
        $revenues = Revenue::with(['category'])->get();
        return $this->sendResponse($revenues, 'Revenues retrieved successfully');
    }

    public function store(SaveRevenueRequest $request)
    {

        Log::info('Attempting to create a new revenue record.', ['request_data' => $request->all()]);
        $data = $request->validated();
        try {
            $revenue = DB::transaction(function () use ($data) {
                $revenue = Revenue::create([
                    'amount' => $data['amount'],
                    'description' => $data['description'],
                    'date' => $data['date'],
                    'category_id' => $data['id_category'],
                    'account_id' => $data['id_account'],
                ]);

                return $revenue;
            });
            return $this->sendResponse($revenue, 'Revenue created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating revenue record.', ['error_message' => $e->getMessage(), 'request_data' => $data]);
            return $this->sendError('Error creating revenue record', [], 500);
        }
    }
}

