<?php

namespace App\Models\Default;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $primaryKey = 'id_category';
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}