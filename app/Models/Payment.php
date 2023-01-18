<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * Get the Transactions for the Payment.
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
    
    protected $fillable = [
        'estado',
        'transaction_id',
        'created_at',
        'updated_at'
   ];
}
