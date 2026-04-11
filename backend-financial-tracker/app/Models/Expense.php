<?php

namespace App\Models;

use App\Models\Default\Categories;
use App\Models\Default\ProductServices;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $primaryKey = 'id_expense';

    protected $casts = [
        'date' => 'date',
    ];

    protected $fillable = [
        'amount',
        'description',
        'payment_method',
        'date',
        'category_id',
        'product_service_id',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id_category');
    }
    public function productService()
    {
        return $this->belongsTo(ProductServices::class, 'product_service_id', 'id_product_service');
    }
}