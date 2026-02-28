<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Default\Accounts;
use App\Models\Default\Categories;
use App\Models\Default\ProductServices;
use Illuminate\Http\Request;

class DefaultController extends BaseController
{

  public function getCategories()
  {
    $categories = Categories::all();
    return $this->sendResponse($categories, "Categories retrieved successfully");
  }

  public function getProductsServices()
  {
    $productsServices = ProductServices::all();
    return $this->sendResponse($productsServices, "Products and Services retrieved successfully");
  }

  public function getAccounts()
  {
    $accounts = Accounts::all();
    return $this->sendResponse($accounts, "Accounts retrieved successfully");
  }

  public function createCategories(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:100',
      'description' => 'nullable|string|max:500',
    ]);

    $idCategory = Categories::create([
      'name' => $request->name,
      'description' => $request->description,
    ])->id_category;


    return $this->sendResponse($idCategory, "Category created successfully");
  }


  public function createProductsServices(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:100',
      'description' => 'required|string|max:500',
    ]);

    $idProductService = ProductServices::create([
      'name' => $request->name,
      'description' => $request->description,
    ])->id_product_service;

    return $this->sendResponse($idProductService, "Product Service created successfully");
  }

  public function createAccount(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:100',
      'type' => 'required|string|in:savings,credit,debit',
      'current_balance' => 'required|numeric|min:0',
    ]);

    $idAccount = Accounts::create([
      'name' => $request->name,
      'type' => $request->type,
      'current_balance' => $request->current_balance,
    ])->id_account;

    return $this->sendResponse($idAccount, "Account created successfully");
  }
}
