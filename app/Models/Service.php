<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
    * Get the Manifold that owns the Service.
    */
    // public function manifold()
    // {
    //     return $this->belongsTo('App\Models\Manifold');
    // }

    /**
     * The manifolds that belong to the service.
     */
    public function manifolds()
    {
        return $this->belongsToMany(Manifold::class, 'service_manifold');
    }

    public static function get_services_selected($services_id, $region){
        $id_region = intval($region);

        $data_services = Service::select('services.id','services.valor','services.nombre','services.codigo', 'manifolds.id as id_manifold')
            ->join('service_manifold','services.id', 'service_manifold.service_id')
            ->join('manifolds','manifolds.id', 'service_manifold.manifold_id')
            ->whereRaw("(manifolds.region_id = $id_region OR manifolds.region_id IS NULL)")
            ->whereIn('services.codigo', $services_id)
            ->get();

        // $sum_values_services = DB::table('services')
        // ->whereIn('id',$services_id)
        // ->sum('valor');

        // return array(
        //         "servicios"     => $data_services,
        //         // "monto_total"   => $sum_values_services
        //     );
        
        return $data_services;
    }

    public static function cod_services_selected($services){

        $code_services = array();
        foreach($services as $service){
            $code_services[] = $service['codigo'];
        }

        return $code_services;
    }

}
