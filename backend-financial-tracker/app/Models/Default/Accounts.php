<?php

namespace App\Models\Default;

use Illuminate\Database\Eloquent\Model;
class Accounts extends Model
{
  protected $table = 'accounts';

  protected $primaryKey = 'id_account';

  protected $fillable = [
    'name',
    'type', 
    'current_balance',
  ];

  protected $hidden = [
    'updated_at',
    'deleted_at',
  ];
}