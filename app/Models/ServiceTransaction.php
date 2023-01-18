<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTransaction extends Model
{
    //
    /**
    * Get the Transaction that owns the Servicetranscion.
    */
   public function transaction()
   {
       return $this->belongsTo('App\Models\Transaction');
   }

   protected $fillable = [
        'nombre',
        'codigo',
        'valor',
        'transaction_id',
        'created_at',
        'updated_at',
        'cantidad',
        'total',
        'total_con_retencion',
        'manifold_id'
    ];
}
