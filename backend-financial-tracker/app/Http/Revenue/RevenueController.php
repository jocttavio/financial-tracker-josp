<?php

namespace App\Http\Revenue;

use App\Http\Controllers\BaseController;
use App\Http\Revenue\Requests\SaveRevenueRequest;
use App\Http\Revenue\RevenueValidations;
use App\Models\Revenue;
use Illuminate\Http\Request;

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
        $data = $request->validated();
        $revenue = Revenue::create($data);
        return $this->sendResponse($revenue, 'Revenue created successfully');
    }
}

