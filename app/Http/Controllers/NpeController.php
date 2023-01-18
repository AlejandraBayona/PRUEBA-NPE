<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Entity;
use App\Models\Region;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Manifold;
use Ayeo\Barcode\Builder;
use App\Models\Department;
use App\Models\Contributor;
use App\Models\Correlative;
use App\Models\Transaction;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\CollectorSite;
use App\Models\UserContributor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use App\Services\Implementation\NpeServiceImpl;

class NpeController extends Controller
{
     /**
     * @var NpeServiceImpl
     * 
     */
    private $npeService;

    /**
     * @var Request
     */
    private $request;

    public function __construct(NpeServiceImpl $npeService, Request $request)
    {
        $this->npeService = $npeService;
        $this->request = $request;
        $this->globalUriMH = "https://ministerio_hacienda";
        $this->uri_cons_indv_mand = "/serviciosdgt/security/api/v1/paids/";
    }

    
    public function login(Request $request)
    {

        return redirect()->route('/creacion_npe');
        
    }


    /**
     * Display a index view.
     *
     * @return view
     */
    public function index()
    {

        if(session_status() === PHP_SESSION_NONE) 
        { 
            session_start();
        }
        if(!isset($_SESSION['login'])){

            $_SESSION["error_login"] = "Por favor, inicie sesion";
            return redirect('/');

        }

        if($_SESSION['login'] != "Si"){

            $_SESSION["error_login"] = "Por favor, inicie sesion";
            return redirect('/');
            
        }

        if((time() - $_SESSION['acceso']) > 1000){

            session_unset();
            session_destroy();

            if(session_status() === PHP_SESSION_NONE) { 
                session_start(); 
            }
            $_SESSION["error_login"] = "Por favor, inicie sesion";
            return redirect('/');

        }

        $nit = $_SESSION['nit'];

        return view('npe.index', [ 
            'uri'               => URL::to('/'),
            'nit'               => $nit,
        ]);

    }

    public function validate_nit(){
        $nit_valid = true;
        if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }

        if($nit_valid == true){
            $_SESSION["valid_nit"] = "Si";
            return redirect("/form_npe");
        }else{
            $_SESSION["valid_nit"] = "No";
            $_SESSION["msg_nit"] = "Por favor ingrese un numero de NIT valido";
            return redirect("/creacion_npe");
        }
        
    }

    public function form_npe(){

        if(session_status() === PHP_SESSION_NONE) 
        { 
            session_start(); 
        }
        if(!isset($_SESSION['login'])){

            $_SESSION["error_login"] = "Por favor, inicie sesion";
            return redirect('/');

        }
        if($_SESSION['login'] != "Si"){
            $_SESSION["error_login"] = "Por favor, inicie sesion";
            return redirect('/');
        }

        if((time() - $_SESSION['acceso']) > 1000){
            session_unset();
            session_destroy();

            if(session_status() === PHP_SESSION_NONE) { 
                session_start(); 
            }
            $_SESSION["error_login"] = "Por favor, inicie sesion";
            return redirect('/');
        }

        if(!isset($_SESSION['valid_nit'])){

            $_SESSION["msg_nit"] = "NIT Invalido";
            return redirect('/creacion_npe');

        }

        if($_SESSION['valid_nit'] != "Si"){

            $_SESSION["msg_nit"] = "Por favor valide su numero de NIT";
            return redirect('/creacion_npe');
            
        }
        $_SESSION["valid_nit"] = "No";

        $nit = $_SESSION['nit'];

        $departments = Department::all();
        $manifolds = Manifold::all();
        $sites_collector = CollectorSite::where('estado', 1)->get();

        $services = Service::select(DB::raw('DISTINCT services.id, services.codigo, services.valor, services.nombre'))
                    ->join('service_manifold','services.id', 'service_manifold.service_id')
                    ->join('manifolds','manifolds.id', 'service_manifold.manifold_id')
                    ->where('services.estado', 1)
                    ->where('manifolds.estado', 1)
                    ->get();
        
        return view('npe.form_npe', [ 
            'manifolds'         => $manifolds,
            'departments'       => $departments,
            'uri'               => URL::to('/'),
            'sites_collector'   => $sites_collector,
            'services'          => $services,
            'nit'               => $nit,
        ]);

    }

    /**
     * Obteniendo Servicios de un Colector
     *
     * @return Json Response
     */
    public function get_services_colector(Request $request)
    {
        try{
            if ( $request->ajax() ) {
                if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
                $_SESSION["acceso"] = time();
                $services = array();
                $value_colector = 0;

                $value_colector = $request->value_colector;
                $services = Manifold::find($value_colector)->services;

                return response()->json( [
                        'success'   => true,
                        'message'   => "Lista de servicios por colector",
                        'services'  => $services
                    ] 
                );
            }
        }catch(\Exception $e){
            if ( $request->ajax() ) {

                return response()->json( [
                    'success' => false,
                    'message' => '¡Error!, Este se registro un error al obtener lista de servicios.',
                    'system_error' => $e->getMessage()
                ] );
            }

        }
    }


    /**
     * Obteniendo Municipios de un Departamento
     *
     * @return Json Response
     */
    public function get_municipios_departamento(Request $request)
    {
        try{
            if ( $request->ajax() ) {
                if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
                $_SESSION["acceso"] = time();
                $municipios = array();
                $value_municipio = 0;

                $value_departamento = $request->value_departamento;
                $municipios = Department::find($value_departamento)->municipalities;

                return response()->json( [
                        'success'   => true,
                        'message'   => "Lista de municipios por departamento",
                        'services'  => $municipios
                    ] 
                );
            }
        }catch(\Exception $e){
            if ( $request->ajax() ) {

                return response()->json( [
                    'success' => false,
                    'message' => '¡Error!, Este se registro un error al obtener lista de municipios.',
                    'system_error' => $e->getMessage()
                ] );
            }

        }
    }


    /**
     * Funcion controladora de Creacion de Mandamiento
     * 
     */
    function create_mandamiento(Request $request){
        //Recuperando data en request

        if ( $request->ajax() ) {
            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
            $_SESSION["acceso"] = time();

            $data_request = $this->request->all();  

            $mytime = Carbon::now('America/El_Salvador');
            /** Validaciones de Datos Requeridos para validar NPE */
            
            
            
            $monto_pagar = 0;

            
            /*
            *  Validando datos null o vacios 
            */ 

            $return_validation_request = $this->npeService->validateDataRequest($data_request);

            if($return_validation_request["error"] === true){
                $response = response($return_validation_request, 200);
                return $response;
            }

            $numberNit = $request->numberNit;
            
            if(preg_match('/^([0-9]{14})$/', $numberNit) == 0){  

                $return_service = array(
                    "error"   => true, 
                    "message"   => "Error nit en formato invalido",
                    "data"      => array()  
                );  

                $response = response($return_service, 200);
                return $response;     

            }

            

            $timestamp_now = Carbon::now()->addDays(10)->timestamp . "000";
            $period = $mytime::now()->format('mY');
            $dateVencimiento = Carbon::now()->addDays(10)->format('Ymd');
            
            $idEntidad = (int) $request->entidadId;

            
            $post_servicios = $data_request['servicios'];
             
            $data_invoice = $request->only('nrc', 'tipoFactura', 'giro', 'nSerieRetencion', 'correlativoRetencion', 'direccion', 'departamento', 'municipio', 'colectorRetiroFactura','opcionalNSolicitud');
            $id_dep                 = (int) $data_invoice['departamento'];
            $department             = Department::find($id_dep);
            $region                 = Region::find($department->region_id); 

            $code_servicios = Service::cod_services_selected($post_servicios); 

            
            $services =  Service::get_services_selected($code_servicios,$department->region_id);

            $total_amount_service = 0;
            
        
            foreach($services as $ky => $serv){

                foreach($post_servicios as $val){

                    if($serv['codigo'] == $val['codigo']){

                        $services[$ky]['cantidad'] = $val['cantidad'];
                        $services[$ky]['total'] = intval($val['cantidad']) * $serv['valor'];
                        $total_amount_service += intval($val['cantidad']) * $serv['valor'];
                        // $services[$ky]['valor_con_retencion'] = NULL;
                    }

                }

            }

            

            $total_amount_service = round($total_amount_service,2);
            $monto_pagar = $total_amount_service;
            $retencion = 0;
            $total_con_retencion = $total_amount_service;
            $flag_retencion = 0;
            /**
             * Caso especial si es gran contribuyente y sus servicios suman mas de 100 dolares
             * se calculara retencion y se descontara de valor a pagar 
             */
            if($data_request['tipoContribuyente'] == 5 && $data_request['tipoFactura'] == 'credito-fiscal'){
                if($total_amount_service > 100){
                    $flag_retencion = 1;
                    // foreach($services as $ky => $serv){

                    //     $retencion_indv = round((($serv['total'] / 1.13) * 0.01) * 100) / 100;
                    //     $services[$ky]['valor_con_retencion'] =  $serv['total'] - $retencion_indv;
                    //     $retencion += $retencion_indv;
                    // }
                    $total_sin_iva = round($total_amount_service / 1.13, 2);
-                   $retencion = round($total_sin_iva * 0.01, 2);
                    $monto_pagar = round($total_amount_service - $retencion, 2);

                }
            }else if($data_request['tipoContribuyente'] == 5 && $data_request['tipoFactura'] == 'consumidor-final'){
                if($total_amount_service > 100 && $data_request['opcionalRetencion'] == 1){

                    $flag_retencion = 1;
                    // foreach($services as $ky => $serv){

                    //     $retencion_indv = round((($serv['total'] / 1.13) * 0.01) * 100) / 100;
                    //     $services[$ky]['valor_con_retencion'] =  $serv['total'] - $retencion_indv;
                    //     $retencion += $retencion_indv;
                    // }
                    // $retencion = round($retencion,2);
                    $total_sin_iva = round($total_amount_service / 1.13, 2);
-                   $retencion = round($total_sin_iva * 0.01, 2);
                    $monto_pagar = round($total_amount_service - $retencion, 2);

                }
            }
            
            switch($data_request['tipoContribuyente']){
                case "1":
                    $data_request['tipoContribuyente'] = "Persona Natural";
                    break;
                case "2":
                    $data_request['tipoContribuyente'] = "Persona Juridica";
                    break;
                case "3":
                    $data_request['tipoContribuyente'] = "Pequeño Contribuyente";
                    break;
                case "4":
                    $data_request['tipoContribuyente'] = "Mediano Contribuyente";
                    break;
                case "5":
                    $data_request['tipoContribuyente'] = "Gran Contribuyente";
                    break;
                case "6":
                    $data_request['tipoContribuyente'] = "Otros Contribuyente";
                    break;
                default:
                    $data_request['tipoContribuyente'] = "Otros Contribuyente";
                    break;        
            }

            switch($data_request['personeria']){
                case "1":
                    $data_request['personeria'] = "persona-natural";
                    break;
                case "2":
                    $data_request['personeria'] = "persona-juridica";
                    break;
                default:
                    $data_request['personeria'] = "persona-natural";
                    break;        
            }



            $entidad = Entity::find($idEntidad);
            if($entidad == null){
                $return_service = array(
                    "error"   => true, 
                    "message"   => "Error, entidad no encontrada para procesamiento",
                    "data"      => array()  
                );  

                $response = response($return_service, 200);

                return $response;  
            }
            
            
            $id_colector_send_fact  = (int) $data_invoice['colectorRetiroFactura'];
            $colector_send_fact     = CollectorSite::find($id_colector_send_fact);
            $nombre_user = UserContributor::select('username')
                        ->where('nit', '=' , $numberNit)
                        ->first();

            $data_merge = array_merge(
                $request->only('numberNit', 'inputFirstName', 'inputLastName','email','tipoContribuyente'),
                $entidad->only('pre_cod_loc', 'cod_loc', 'pre_cant_pagar','pre_fecha_venc','referencia','codigo_loc_mh','comodin','pre_ref_pago','origen_pago'),
                [
                    'fechaVenc'     => $dateVencimiento,
                    'cuentaCont'    => '41250853004',
                    'dueDate'       => $timestamp_now,
                    'period'        => $period,
                    'username'      => $nombre_user->username,
                    'montoPagar'    => $monto_pagar,
                    'retencion'     => $retencion
                ]
            ); 
            

            /*
            *  Validando datos null o vacios 
            */ 
            
            $return_validation = $this->npeService->validateData($data_merge);

            if($return_validation["error"] === true){
                $response = response($return_validation, 200);
                return $response;
            }

            /*
            * Preparando array para ser enviado a servicio MH
            */
            $taxesMh = array();

            
            foreach($services as $servicio){
                $taxesMh[] = array(
                    "code" => $servicio->codigo,
                    "amount" => number_format($servicio->total,2,'.','')
                );
            }
            
            
            /**
             * Obtencion de Correlativo 
             * Status 1 - Disponible
             * Status 2 - En Proceso
             * Status 0 - No Disponible
             */

            /** Consultare si hay un correlativo en estado 2, con mas de 20 min en ese estado */
            
            $corr_not_used = Correlative::correlativeNotUsed(); 
            $last_correlative = (object) array();

            if($corr_not_used ===  false){
                $last_correlative = Correlative::get_last_correlative();
              
                /** 
                 * Flujo alternativo, solo en caso que no se obtenga ultimo correlativo 
                 */
                
                if(!isset($last_correlative)){
                    //No resivi ultimo correlativo
                    //Primero revisare si hay algun correlativo con status 1
                        $return_service = array(
                            "error"   => true, 
                            "message"   => "Problemas en el servidor para generar NPE, ultimo correlativo",
                            "data"      => array()  
                        );  
        
                        $response = response($return_service, 200);
                        return $response;  
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
                
            }else{
                $last_correlative->correlativo = $corr_not_used;
                $new_corr = (int) $last_correlative->correlativo;
            }

            
            /**
             * Fin Proceso obtencion de correlativo
             */

            $data_merge = array_merge(
                $data_merge,
                [
                    'correlativo'   => $last_correlative->correlativo
                ]
            );


            $data_send_api_mh = $this->npeService->dataCreateMh($data_merge, $taxesMh);

            /* 
            * Ahora me conectare a servicio MH 
            */

            $return_service = $this->npeService->postNpe($data_send_api_mh);

            // $return_service = array('error' => false);

            $respuesta_mh = $return_service;
            //ocurrio un error con mh retornare aqui a error
            if($return_service['error'] === true){
                //Proceso a realizar si sale mal comunicacion a MH
                $return_service = array(
                    "error"   => true, 
                    "message"   => "Problemas en el servidor para generar NPE",
                    "data"      => $respuesta_mh 
                ); 
                $response = response($return_service, 200);
                return $response;
            }

            $correlative = app('db')->table('correlatives')
                                ->where('correlativo', $new_corr)
                                ->update(['estado' => 0]);


             /**
             * En este momento si hacienda respondio exitoso el ingreso de mandamiento procedere 
             * crear NPE
             * 
             */

            $code_bar = $this->npeService->createCodeBarNpe($data_merge, $taxesMh);

            // $response = response($code_bar, 200);

            $return_service = array(
                "error"   => false, 
                "message"   => "Code bar",
                "data"      => $code_bar  
            );  

            $transaction = Transaction::create([
                'npe'                   => $code_bar['num_npe'],
                'number_cod_bar'        => $code_bar['num_code_bar'],
                'correlativo'           => $last_correlative->correlativo,
                'origen_pago'           => $data_merge['origen_pago'],
                'referencia'            => $data_merge['referencia'],
                'total_pagar'           => $monto_pagar,
                'retencion'             => $retencion,
                'total_con_retencion'   => $total_con_retencion,
                'fecha_emision'         => Carbon::now()->toDateTimeString(),
                'fecha_vencimiento'     => Carbon::now()->addDays(10)->format('Y-m-d'),
                'entity_id'             => 1,
                'created_at'            => Carbon::now()->toDateTimeString()
            ]);

            $id_transaction = $transaction->id;

            $contributor = Contributor::create([
                'nombre'                => $data_merge['inputFirstName'],
                'apellido'              => $data_merge['inputLastName'],
                'nit'                   => $data_merge['numberNit'],
                'email'                 => $data_merge['email'],
                'tipo_contribuyente'    => $data_request['tipoContribuyente'],
                'personeria'            => $data_request['personeria'],
                'transaction_id'        => $id_transaction,
                'created_at'            => Carbon::now()->toDateTimeString()
            ]);

            $invoice = Invoice::create([
                'nrc'                   => $data_invoice['nrc'],
                'tipo_factura'          => $data_invoice['tipoFactura'],
                'giro_contribuyente'    => $data_invoice['giro'],
                'num_serie_retencion'   => $data_invoice['nSerieRetencion'],
                'num_cor_retencion'     => $data_invoice['correlativoRetencion'],
                'region_servicio'       => $region->id,
                'direccion'             => $data_invoice['direccion'],
                'departamento'          => $data_invoice['departamento'],
                'municipio'             => $data_invoice['municipio'],
                'destino_factura'       => $data_invoice['colectorRetiroFactura'],
                'codigo_solicitud'      => $data_invoice['opcionalNSolicitud'],
                'transaction_id'        => $id_transaction,
                'created_at'            => Carbon::now()->toDateTimeString()
            ]);

            $invoice = Payment::create([
                'estado'                => 0,
                'transaction_id'        => $id_transaction,
                'created_at'            => Carbon::now()->toDateTimeString()
            ]);
            
            $insert_service_transaction = array();
            
            foreach($services as $service){
                $insert_service_transaction[] = array(
                    'codigo'        => $service['codigo'],
                    'nombre'        => $service['nombre'],
                    'valor'         => $service['valor'],
                    'cantidad'      => intval($service['cantidad']),
                    'total'         => $service['total'],
                    'manifold_id'   => $service['id_manifold'],
                    'created_at'    => Carbon::now()->toDateTimeString()
                );
            };

            $transaction->servicetransactions()->createMany($insert_service_transaction);

            
            $nit_format = "";
            for($i=0; $i<strlen($data_merge['numberNit']); $i++){
                if($i == 3 || $i == 9 || $i == 12){
                    $nit_format = $nit_format .substr($data_merge['numberNit'],$i,1) . "-";
                }else{
                    $nit_format = $nit_format . substr($data_merge['numberNit'],$i,1);
                }
                
            } 

            $split_npe = str_split($code_bar['num_npe'], 4);
            $data_merge['npe_with_space'] = implode(' ', $split_npe);
            $data_merge['period'] = $mytime::now()->format('m/Y');
            $data_merge['fecha_vencimiento'] = Carbon::now()->addDays(10)->format('d/m/Y');

            $data_merge['usuario'] = $nombre_user->username;

            $data_merge['nit_format'] = $nit_format;
            $total_cantidad_servicios = count($services);

            $data_merge['id_transaction'] = $id_transaction;
            /**
             * creacion de codigo de barra
             */

            $builder = new Builder();
            $builder->setBarcodeType('gs1-128');
            $builder->setFilename("barcode_$id_transaction.png");
            $builder->setImageFormat('png');    
            
            $builder->setWidth(360);
            $builder->setHeight(56);
            $builder->setFontSize(1);
            $builder->setBackgroundColor(255, 255, 255);
            $builder->setPaintColor(0, 0, 0);
            $builder->saveImage($code_bar['num_code_bar_imp']);

            $data_time_now = $mytime::now()->format('Y/m/d g:i:s A');
            /**
             * creacion de pdf
             */
            $pdf = App::make('dompdf.wrapper');
            $customPaper = array(0,0,654,860);
            // $pdf->setPaper('A4','portrait');
            $pdf->setPaper($customPaper);
            $pdf->loadView('pdf.mandamiento_ingreso', compact("data_merge", "data_invoice", "code_bar","last_correlative","services","total_cantidad_servicios","id_transaction","insert_service_transaction","flag_retencion","retencion","data_time_now","colector_send_fact"))->save(storage_path() . "/app/mandamientos/mandamiento_$id_transaction.pdf");
            
            

            $return_service = array(
                "error"   => false, 
                "message"   => "id",
                "data"      => $id_transaction ,
                "npe"       => $code_bar['num_npe'],
                "url"       => URL::to('/'),
                "respuesta_mh" => $respuesta_mh
            );  

           
            $response = response($return_service, 200);

            return $response; 
        }    
    }


    function desplagarModalPago(Request $request){
        
        
        if(!isset($request->id_transaction)){
            $return_service = array(
                "error"   => true, 
                "message"   => "ID de transaccion no definido",
                "data"      => array()  
            );  

            $response = response($return_service, 200);
            return $response;
        }

        if($request->id_transaction == ""){
            $return_service = array(
                "error"   => true, 
                "message"   => "ID de transaccion vacio",
                "data"      => array()  
            );  

            $response = response($return_service, 200);
            return $response;
        };



        $id_transaction = $request->id_transaction;
        $id_transaction = intval($id_transaction);

        $transaction = Transaction::find($id_transaction);

        

        if($transaction == null){

            $return_service = array(
                "error"   => true, 
                "message"   => "No se encontro transaccion",
                "data"      => array()  
            );  

            $response = response($return_service, 200);
            return $response;

        }

        $npe = $transaction->npe;

        $url_base = env('URL_MH_BASE_DEV_S');

            $url = $url_base . "dgtserfinsa/rnwy?npe=$npe";
            
            $resp = Http::post($url,[]);
            
            $respuesta = $resp->body();
            
            $ruta = $url_base . "dgtserfinsa/";
            $respuesta = str_replace("/dgtserfinsa/", $ruta, $respuesta);

            $return_service = array(
                "error"   => true, 
                "message"   => "Todo bien",
                "data"      => $respuesta
            );  

            $response = response($return_service, 200);
            return $response;

    }


    
    /**
     * Funciones controladoras de Consulta Individual de Mandamiento
     * 
     */
    function consultarMandIndv(){
        //Recuperando data en request
        $data_request = $this->request->all();

        /*
         *  Validando datos null o vacios 
         */ 

        $return_validation = $this->npeService->validateDataMandamiento($data_request);

        if($return_validation['error'] === true){

            $response = response($return_validation, 200);
            return $response;

        }

        /** Funcion para conectarse a servicio MH */

        $return_service = $this->npeService->getIndvMand($data_request['numberMandamiento'], $this->uri_cons_indv_mand);

        $return_service = array(
            "error"     => false, 
            "message"   => "Obtencion de Informacion de Mandamiento",
            "data"      => array(
                "numberMandamiento" => $data_request['numberMandamiento']
            )  
        );



        $response = response($return_service, 200);
        
        return $response;
        
    }


} /** Fin NpeController */
