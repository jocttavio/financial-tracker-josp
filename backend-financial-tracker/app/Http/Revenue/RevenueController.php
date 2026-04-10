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
    public function summary(Request $request)
    {
        try {
            $summary = Revenue::select(
                DB::raw('SUM(amount) as total_revenue'),
                DB::raw('COUNT(*) as total_entries'),
            )
            ->first();

            // subfunction to get revenue by category
            $summaryByMonth = Revenue::select(
                DB::raw('SUM(amount) as total_revenue_by_month'),
                DB::raw('COUNT(*) as total_entries_by_month'),
            )
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->first();

            // combine both summaries into a single response
            $response = [
                'total_revenue' => $summary->total_revenue,
                'total_entries' => $summary->total_entries,
                'average_revenue' => $summary->total_entries > 0 ? $summary->total_revenue / $summary->total_entries : 0,
                'current_month_revenue' => $summaryByMonth->total_revenue_by_month ? $summaryByMonth->total_revenue_by_month : 0,
                'current_month_entries' => $summaryByMonth->total_entries_by_month ? $summaryByMonth->total_entries_by_month : 0,
            ];

            return $this->sendResponse($response, 'Revenue summary retrieved successfully');
        } catch (\Exception $e) {
            Log::error('Error retrieving revenue summary.', ['error_message' => $e->getMessage()]);
            return $this->sendError('Error retrieving revenue summary', [], 500);
        }
    }
}

