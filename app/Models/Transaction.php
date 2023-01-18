<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
    * Get the Entity that owns the Transaction.
    */
   public function entity()
   {
       return $this->belongsTo('App\Models\Entity');
   }

   /**
     * Get the user contributor associated with the transaction.
     */
    public function contributor()
    {
        return $this->hasOne('App\Models\Contributor');
    }
    /**
     * Get the user contributor associated with the transaction.
     */
    public function payments()
    {
        return $this->hasOne('App\Models\Payment');
    }

    /**
     * Get the Servicetransactions for the Transaction.
     */
    public function servicetransactions()
    {
        return $this->hasMany('App\Models\ServiceTransaction');
    }

   protected $fillable = [
        'npe',
        'number_cod_bar',
        'correlativo',
        'origen_pago',
        'referencia',
        'total_pagar',
        'retencion',
        'total_con_retencion',
        'fecha_emision',
        'fecha_vencimiento',
        'entity_id',
        'created_at',
        'updated_at'
   ];
   
}
