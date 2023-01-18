<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Department;
use App\Models\Contributor;
use App\Models\Correlative;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Implementation\NpeServiceImpl;

class MandamientoController extends Controller
{
    protected $order, $time;
    /**
     * @var NpeServiceImpl
     * 
     */
    private $npeService;

    /**
     * @var Request
     */
    private $request;

    public function __construct(Order $order,NpeServiceImpl $npeService, Request $request)
    {
        $this->order = $order;
        $this->time = Carbon::now('America/El_Salvador');
        $this->npeService = $npeService;
        $this->request = $request;
        $this->globalUriMH = "https://ministerio_hacienda";
        $this->uri_cons_indv_mand = "/serviciosdgt/security/api/v1/paids/";
    }

    



    /**
     * 
     * Funcion para generar e ingregar un mandamiento de pago en Hacienda
     * 
     */


    public function generarMandamientoPago(Request $request)
    {

        /******* Validando Datos *****/
        $validator = Validator::make($request->all(), [
            'nit'                       => 'required|max:14|min:14',
            'nrc'                       => 'required',
            // 'nombres'                   => 'required|max:35',
            'apellidos'                 => 'max:70',
            'actividadEconomica'        => 'required|max:250',
            'direccion'                 => 'required|max:250',
            'telefono'                  => 'required|max:8|min:8',
            'noDocumento'               => 'required',
            'origen'                    => 'required',
            'retencionIva'              => 'required',
            'usuario'                   => 'required',
            'tipoComprobante'           => 'required',
            'detalles'                  => 'required',
            'actualizarContribuyente'   => 'required',
            'departamento'              => 'required',
            'municipio'                 => 'required',
            'colectorRetiroFactura'     => 'required',
        ]);

        if ($validator->fails()) {
            return response(
                [
                    'message'   => 'Validation errors',
                    'errors'    =>  $validator->errors(),
                    'status'    => false,
                    'error'     => 0,
                ],
                200
            );
        }

        $validatorDetails = Validator::make($request->detalles, [
            "*.codigo"      => 'required',
        ]);

        if ($validatorDetails->fails()) {
            return response(
                [
                    'message'   => 'Validation errors',
                    'errors'    =>  $validatorDetails->errors(),
                    'status'    => false,
                    'error'     => 0,
                ],
                200
            );
        }


        /***
         * Obtencion de ultimo correlativo
         */
        $correlativo = Correlative::get_last_correlative_api();
        
        if ($correlativo["status"] === false) {
            return response(
                $correlativo,
                200
            );
        }

        

        $datosEntidad = array(
            "referencia"            => "633",
            "cuentaContable"        => "41250853004",
            "fechaVencimiento"      => Carbon::now()->addDays(10)->timestamp . "000",
            "periodo"               => $this->time::now()->format('mY'),
            "codigoEspecificoPrin"  => "41202",
            "correlativo"           => $correlativo["data"],
            "origenPago"            => "63",
        );

        $code_servicios = array();
        foreach($request->detalles as $servicio){
            $code_servicios[] = $servicio["codigo"];
            
        }

        $department = Department::find($request->departamento);
        $services   =  Service::get_services_selected($code_servicios,$department->region_id);


        $montoPagar =  $this->order->calculoMontoPagar($services, $request->all());
        
        /**
         * Trama Para Enviar a API Hacienda
         */

        $dataToSendHacienda = $this->order->generarTramaHacienda($request->all(), $datosEntidad, $montoPagar);
        
        /*
         * 
         * *
         * * * Conexion API Hacienda
         * * 
         */
        
        $returnServiceHacienda = $this->npeService->postNpe($dataToSendHacienda);
        // $returnServiceHacienda = array(
        //     "error"     => false,
        //     "message"   => "success",
        //     "data"      => "0463000001002420211211063300000109",
        //     "size"      => 1
        // );
        if ($returnServiceHacienda['error'] === true) {
            //Proceso a realizar si sale mal comunicacion a Hacienda

            return response(
                [
                    'message'   => "Validation errors",
                    'errors'    => "Problemas en el servidor para generar NPE",
                    'status'    => false,
                    'error'     => 1,
                    "data"      => $returnServiceHacienda
                ],
                200
            );
        }
        // $contribuyenteBD = Contributor::where('nit', $request->nit)->first();

        /**
         * Registro de Contribuyente, si contribuyente no se encuentra lo insertare
         * si ya se encuentra solo vere si requiere actualizacion
         */

        // if ($contribuyenteBD === null) {
        //     $contribuyente = new Contributor();
        //     $contribuyente->nit                     = $request->nit;
        //     $contribuyente->nrc                     = $request->nrc;
        //     $contribuyente->dui                     = $request->dui;
        //     $contribuyente->nombres                 = $request->nombres;
        //     $contribuyente->apellidos               = $request->apellidos;
        //     $contribuyente->direccion               = $request->direccion;
        //     $contribuyente->telefono                = $request->telefono;
        //     $contribuyente->categoriaContribuyente  = $request->categoriaContribuyente;
        //     $contribuyente->usuario                 = $request->usuario;
        //     $contribuyente->save();
        // } else {
        //     if ($request->actualizarContribuyente === "SI") {
        //         $contribuyente = Contributor::where('nit', $request->nit)->first();
        //         $contribuyente->nrc                     = $request->nrc;
        //         $contribuyente->dui                     = $request->dui;
        //         $contribuyente->nombres                 = $request->nombres;
        //         $contribuyente->apellidos               = $request->apellidos;
        //         $contribuyente->direccion               = $request->direccion;
        //         $contribuyente->telefono                = $request->telefono;
        //         $contribuyente->categoriaContribuyente  = $request->categoriaContribuyente;
        //         $contribuyente->usuario                 = $request->usuario;
        //         $contribuyente->save();
        //     }
        // }

        $dataBarcodeNpe = array(
            "preCodLoc"             => "415",
            "codLoc"                => "7419700004639",
            "preCantPagar"          => "3902",
            "preFechaVenc"          => "96",
            "preRefPago"            => "8020",
            "referencia"            => "633",
            "correlativo"           => $correlativo["data"],
            "fechaVenc"             => Carbon::now()->addDays(10)->format('Ymd'),
            "npeFechaVencimiento"   => Carbon::now()->addDays(10)->format('Y-m-d'),
            "tipoComprobante"       => $request->tipoComprobante,
        );

        /*** Creacion de Codigo de Barra */
        $codeBar = $this->order->createCodeBarNpe($dataToSendHacienda, $returnServiceHacienda, $dataBarcodeNpe);
        

        /**
         * Insercion de Orden o info de mandamiento de pago en BD
         */
        // $order                      = new Order();
        // $order->npe                 = $codeBar["numNpe"];
        // $order->numberCodBar        = $codeBar["numCodeBar"];
        // $order->correlativo         = $dataBarcodeNpe["correlativo"];
        // $order->origenPago          = $datosEntidad["origenPago"];
        // $order->referencia          = $dataBarcodeNpe["referencia"];
        // $order->totalPagar          = $montoPagar["montoPagar"];
        // $order->retencion           = $montoPagar["retencion"];
        // $order->totalConRetencion   = $montoPagar["totalMonto"];
        // $order->fechaVencimiento    = $dataBarcodeNpe["npeFechaVencimiento"];
        // $order->contributor_id      = $contribuyente->id;
        // $order->created_at          = $this->time::now()->format('Y-m-d');
        // $order->save();


        $transaction = Transaction::create([
            'npe'                   => $codeBar["numNpe"],
            'number_cod_bar'        => $codeBar["numCodeBar"],
            'correlativo'           => $dataBarcodeNpe["correlativo"],
            'origen_pago'           => $datosEntidad["origenPago"],
            'referencia'            => $dataBarcodeNpe["referencia"],
            'total_pagar'           => $montoPagar["montoPagar"],
            'retencion'             => $montoPagar["retencion"],
            'total_con_retencion'   => $montoPagar["totalMonto"],
            'fecha_emision'         => Carbon::now()->toDateTimeString(),
            'fecha_vencimiento'     => Carbon::now()->addDays(10)->format('Y-m-d'),
            'entity_id'             => 1,
            'created_at'            => Carbon::now()->toDateTimeString()
        ]);

        /*
        *   Insertare los servicios que se incluyen en el mandamiento
        */

        // $transaction->serviceorders()->createMany($request->detalles);
        
        $insert_service_transaction = array();

            foreach($services as $service){
            
                $insert_service_transaction[] = array(
                    'codigo'        => $service['codigo'],
                    'nombre'        => $service['nombre'],
                    'valor'         => $service['valor'],
                    'cantidad'      => 1,
                    'total'         => $service['valor'],
                    'manifold_id'   => $service['id_manifold'],
                    'created_at'    => Carbon::now()->toDateTimeString()
                );
            };

            $transaction->servicetransactions()->createMany($insert_service_transaction);
            $id_transaction = $transaction->id;
    
        $contributor = Contributor::create([
            'nombre'                => $request->nombres,
            'apellido'              => $request->apellidos,
            'nit'                   => $request->nit,
            'email'                 => $request->usuario,
            'tipo_contribuyente'    => $request->categoriaContribuyente,
            'personeria'            => "natural",
            'transaction_id'        => $id_transaction,
            'created_at'            => Carbon::now()->toDateTimeString()
        ]);

        $invoice = Invoice::create([
            'nrc'                   => $request->nrc,
            'tipo_factura'          => $request->tipoComprobante,
            'giro_contribuyente'    => $request->giro,
            'num_serie_retencion'   => (isset($request->nSerieRetencion)) ? $request->nSerieRetencion : "",
            'num_cor_retencion'     => (isset($request->correlativoRetencion)) ? $request->correlativoRetencion : "",
            'region_servicio'       => $department->region_id,
            'direccion'             => $request->direccion,
            'departamento'          => $request->departamento,
            'municipio'             => $request->municipio,
            'destino_factura'       => $request->colectorRetiroFactura,
            'codigo_solicitud'      => $request->noDocumento,
            'transaction_id'        => $id_transaction,
            'created_at'            => Carbon::now()->toDateTimeString()
        ]);

        $payment = Payment::create([
            'estado'                => 0,
            'transaction_id'        => $id_transaction,
            'created_at'            => Carbon::now()->toDateTimeString()
        ]);

        /**** Creacion de Imagen de Codigo De Barra ***/

        $this->order->crearImageBarCodeNpe($codeBar, $transaction->id);

        /**** Creacion de PDF de Mandamiento de Pago ***/
        $resultadoPdf = $this->order->crearPdfNpe($codeBar, $dataToSendHacienda, $dataBarcodeNpe, $datosEntidad, $id_transaction, $insert_service_transaction);


        if ($resultadoPdf["exito"] === false) {
            return response(
                [
                    'message'   => "Error en creación de PDF",
                    'errors'    => "Problemas en el servidor para generar PDF de mandamiento",
                    'status'    => false,
                    'error'     => $resultadoPdf["pdfBase"],
                    "data"      => $returnServiceHacienda
                ],
                200
            );
        }

        return response(
            [
                'message'   => "Mandamiento de pago generado correctamente (con NPE)",
                'errors'    => "",
                'status'    => true,
                'error'     => false,
                "data"      => array(
                    "id_order"          => 1,
                    "npe"               => $codeBar["numNpe"],
                    "fechaExpiracion"   => $dataBarcodeNpe["npeFechaVencimiento"],
                    "estadoPago"        => "NO PAGADO",
                    "contenidoPdf"      => $resultadoPdf["pdfBase"]
                )
            ],
            200
        );
    }

    /**
     * 
     * Funcion para consultar estado de pago de un mandamiento de pago
     * 
     */

    public function consultaEstadoMandamiento(Request $request)
    {
        /******* Validando Datos *****/
        $validator = Validator::make($request->all(), [
            'npe' => 'required|min:34|max:34'
        ]);

        //Validando obtenener npe
        if ($validator->fails()) {
            return response(
                [
                    'message'   => 'Validation errors',
                    'errors'    =>  $validator->errors(),
                    'status'    => false,
                    'error'     => 0,
                    'data'      => array(),
                ],
                200
            );
        }

        $order = Order::where("npe", $request->npe)->first();

        //Validando que se recupero un registro de la bd con el numero de npe recibido
        if (!isset($order)) {
            return response(
                [
                    'message'   => 'El numero de Mandamiento no se encuentra registrado',
                    'errors'    =>  'Numero NPE no encontrado',
                    'status'    => false,
                    'error'     => 1,
                    'data'      => array(),
                ],
                200
            );
        }
        if ($order->estado === 0) {
            return response(
                [
                    'message'   => 'Mandamiento de pago encontrado',
                    'errors'    => '',
                    'status'    => true,
                    'error'     => '',
                    'data'      => array(
                        "npe"               => $order->npe,
                        "numComprobante"    => "",
                        "estado"            => "NO PAGADO"
                    ),
                ],
                200
            );
        } else if ($order->estado === 1) {
            return response(
                [
                    'message'   => 'Mandamiento de pago encontrado',
                    'errors'    => '',
                    'status'    => true,
                    'data'      => array(
                        "npe"               => $order->npe,
                        "numComprobante"    => $order->numComprobante,
                        "estado"            => "PAGADO",
                    ),
                ],
                200
            );
        } else {
            return response(
                [
                    'message'   => 'Mandamiento de pago con estado no valido',
                    'errors'    => 'Estado De Pago Incorrecto',
                    'status'    => false,
                    'data'      => array(),
                ],
                200
            );
        }
    }
}
