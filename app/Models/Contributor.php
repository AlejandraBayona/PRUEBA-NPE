<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    //
    /**
     * Get the transaction that owns the contributor.
     */
    public function contributor()
    {
        return $this->belongsTo('App\Models\Contributors');
    }

    protected $fillable = [
        'nombre',
        'apellido',
        'nit',
        'tipo_contribuyente',
        'transaction_id',
        'email',
        'created_at',
        'updated_at',
        'personeria'
   ];
}
