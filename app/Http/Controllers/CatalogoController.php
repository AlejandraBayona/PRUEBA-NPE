<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Manifold;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CollectorSite;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Municipality;

class CatalogoController extends Controller
{
    /**
     * Funcion controladora que devuelve valores de catalogos en NPE
     * 
     */
    function catalogos(Request $request)
    {
        //Recuperando data en request

        $departments = Department::all();
        $manifolds = Manifold::all();
        $sites_collector = CollectorSite::where('estado', 1)->get();
        $municipalities = Municipality::all();

        $services = Service::select(DB::raw('DISTINCT services.id, services.codigo, services.valor, services.nombre'))
            ->join('service_manifold', 'services.id', 'service_manifold.service_id')
            ->join('manifolds', 'manifolds.id', 'service_manifold.manifold_id')
            ->where('services.estado', 1)
            ->where('manifolds.estado', 1)
            ->whereIn("services.codigo", $request->input())
            ->get();

        return response(
            [
                'message'   => "Datos de catalogos",
                'errors'    => "",
                'status'    => true,
                'error'     => false,
                "data"      => array(
                    "departaments"      => $departments,
                    "manifolds"         => $manifolds,
                    "sites_collector"   => $sites_collector,
                    "services"          => $services,
                    "municipalities"    => $municipalities,
                )
            ],
            200
        );
    }

    /**
     * Funcion que devuelve el total de servicios en la base de datos NPE
     * 
     */
    function listaServicios(Request $request)
    {
        //Recuperando data en request

        $services = Service::select(DB::raw('DISTINCT services.id, services.codigo, services.valor, services.nombre'))
            ->join('service_manifold', 'services.id', 'service_manifold.service_id')
            ->join('manifolds', 'manifolds.id', 'service_manifold.manifold_id')
            ->where('services.estado', 1)
            ->where('manifolds.estado', 1)
            ->get();

        return response(
            [
                'message'   => "Datos de catalogos",
                'errors'    => "",
                'status'    => true,
                'error'     => false,
                "data"      => array(
                    "services"          => $services,
                )
            ],
            200
        );
    }

    /**
     * Obteniendo Municipios de un Departamento
     *
     * @return Json Response
     */
    public function municipios($departamento)
    {
        try{
                $municipios = array();
                $municipios = Department::find($departamento)->municipalities;

                return response()->json( [
                        'success'   => true,
                        'message'   => "Lista de municipios por departamento",
                        'municipios'  => $municipios
                    ] 
                );
        }catch(\Exception $e){

                return response()->json( [
                    'success' => false,
                    'message' => '¡Error!, Este se registro un error al obtener lista de municipios.',
                    'system_error' => $e->getMessage()
                ] );
        }
    }
    
}
