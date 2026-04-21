<?php 


namespace App\Models\Default;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
  protected $table = 'payment_methods';
  protected $primaryKey = 'id_payment_method';
  protected $fillable = ['name', 'description'];

  protected $hidden = ['updated_at', 'deleted_at'];
}
