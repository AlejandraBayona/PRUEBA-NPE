<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Correlative extends Model
{

    public static function get_last_correlative_api()
    {

        $last_correlative = app('db')->table('correlatives')
            ->select('id', 'correlativo')
            ->orderBy('correlativo', 'desc')
            ->first();

        if (!isset($last_correlative)) {
            //No recibi ultimo correlativo
            $return_service = array(
                'message'   => "No se pudo obtener correlativo",
                'errors'    => "Problemas en el servidor para generar NPE, no se pudo obtener correlativo",
                'status'    => false,
                'error'     => 3,
                "data"      => array()
            );

            return $return_service;
        }

        $last_corr  = (int) $last_correlative->correlativo;
        $new_corr   = $last_corr + 1;
        $insert_correlative = app('db')->table('correlatives')->insert(
                    [
                        "correlativo" =>  $new_corr, 
                        "estado" => 0,
                        "created_at" => Carbon::now()->toDateTimeString()
                    ]
                );
        
        $last_correlative->correlativo = str_pad($new_corr,7,'0',STR_PAD_LEFT);

        $return_service = array(
            'message'   => "No se pudo obtener correlativo",
            'errors'    => "Problemas en el servidor para generar NPE, no se pudo obtener correlativo",
            'status'    => true,
            'error'     => 3,
            "data"      => $last_correlative->correlativo 
        );

        return $return_service;
    }


    public static function get_last_correlative()
    {

        return app('db')->table('correlatives')
            ->select('id', 'correlativo')
            ->orderBy('correlativo', 'desc')
            ->first();
    }


    public static function correlativeNotUsed()
    {

        $mytime = Carbon::now('America/El_Salvador');
        $time = $mytime->subMinutes(20)->format('Y-m-d h:i:s');

        $results = app('db')->select("SELECT lpad(c.correlativo,7,'0') as correlativo, c.id from correlatives c 
                where c.estado = 2
                and c.created_at < '$time'
                order by c.created_at desc
                limit 1");

        if (count($results) > 0) {
            $correlativo = $results[0]->correlativo;

            $result_transaction = app('db')->select("SELECT count(*) as cantidad from transactions t
                where t.correlativo = $correlativo");

            if ($result_transaction[0]->cantidad > 0) {
                //el correlativo tiene transaction insertada
                app('db')->table('correlatives')
                    ->where('id', $results[0]->id)
                    ->update(['estado' => 0]);
                return false;
            } else {
                //utilizar correlativo encontrado
                return $correlativo;
            }
        } else {
            // todo bien no ha quedado nada en proceso
            return false;
        }
    }

    protected $fillable = [
        'correlativo',
        'estado',
        'created_at',
        'updated_at'
    ];
}
