<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    /**
     * Get the transaction that owns the invoice.
     */
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    protected $fillable = [
        'nrc',
        'tipo_factura',
        'giro_contribuyente',
        'num_serie_retencion',
        'num_cor_retencion',
        'region_servicio',
        'direccion',
        'departamento',
        'municipio',
        'destino_factura',
        'transaction_id',
        'codigo_solicitud',
        'created_at',
        'updated_at'
   ];
}
