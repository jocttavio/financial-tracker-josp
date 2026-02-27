<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Default\Categories;
class Revenue extends Model
{
  protected $table = 'revenue';

  protected $primaryKey = 'id_revenue';

  protected $casts = [
        'date' => 'date',
    ];



    protected $fillable = [
        'amount',
        'description',
        'date',
        'category_id',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}