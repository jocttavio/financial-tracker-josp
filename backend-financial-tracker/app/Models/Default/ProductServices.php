<?php

namespace App\Models\Default;

use Illuminate\Database\Eloquent\Model;

class ProductServices extends Model
{
    protected $primaryKey = 'id_product_service';

    protected $table = 'products_services';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}