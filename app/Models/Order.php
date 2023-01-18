<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Ayeo\Barcode\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Get the user contributor associated with the transaction.
     */
    public function contributor()
    {
        return $this->hasOne('App\Contributor');
    }

    /**
     * Get the Servicetransactions for the Transaction.
     */
    public function serviceorders()
    {
        return $this->hasMany('App\ServiceOrder');
    }

    protected $fillable = [
        'npe',
        'numberCodBar',
        'correlativo',
        'origenPago',
        'referencia',
        'totalPagar',
        'retencion',
        'totalConRetencion',
        'fechaEmision',
        'fechaVencimiento',
        'estado',
        'numComprobante',
        'contributor_id',
        'created_at',
        'updated_at'
   ];
   


    public function calculoMontoPagar($services, $request)
    {

        $montoPagar         = 0;
        $totalSinIva        = 0;
        $retencion          = 0;
        $totalMonto         = 0;

        // foreach ($request["detalles"] as $key => $value) {

        //     $montoPagar = $montoPagar + $value["total"];
        // }

        foreach ($services as $key => $value) {

            $montoPagar = $montoPagar + $value->valor;
            
        }



        $totalMonto = $montoPagar;

        if ($request["retencionIva"] === "SI") {
            $totalSinIva = round($montoPagar / 1.13, 2);
            $retencion = round($totalSinIva * 0.01, 2);
            $montoPagar = round($montoPagar - $retencion, 2);
        }

        return array(
            "totalMonto"    => $totalMonto,
            "retencion"     => $retencion,
            "montoPagar"    => $montoPagar,
        );
    }

    public function generarTramaHacienda($request, $datosEntidad, $montoPagar)
    {
        $dataSendHacienda = array(
            "nit"           => $request['nit'],
            "document"      => $datosEntidad['referencia'] . $datosEntidad['correlativo'],
            "account"       => $datosEntidad['cuentaContable'],
            "dueDate"       => $datosEntidad['fechaVencimiento'],
            "period"        => $datosEntidad['periodo'],
            "userAccount"   => $request['usuario'],
            "firstName"     => $request['nombres'],
            "lastName"      => $request['apellidos'],
            "taxCode"       => $datosEntidad['codigoEspecificoPrin'],
            "totalAmount"   => "" . number_format($montoPagar['montoPagar'], 2, '.', '') . "",
            "concept"       => $request['actividadEconomica'],
            "taxes"         => array(
                array(
                    "code" => $datosEntidad['codigoEspecificoPrin'],
                    "amount" => number_format($montoPagar['montoPagar'], 2, '.', '')
                )
            )
        );

        return $dataSendHacienda;
    }

    /***
     * Funcion para conectarse a API Hacienda
     */

    function postNpe(array $npe)
    {
        try {

            $urlBase = env('URL_MH_BASE_DEV_S');

            $url = $urlBase . "serviciosdgt/security/api/v1/documents?df=npe";

            $response = Http::withHeaders([
                'Authorization' => env('TOKEN_MH_DEV')
            ])->post($url, $npe);

            return $response->json();

        } catch (\Exception $e) {

            $return_service = array(
                "error"     => true,
                "message"   => "error",
                "data"      => "error de conexion",
                "size"      => 0
            );
        }
        return $return_service;
    }

    /***
     * Funcion para unir codigo de barra
     *
     */
    function createCodeBarNpe(array $dataToSendHacienda, array $returnServiceHacienda, array $dataBarcodeNpe)
    {
        $montoPagarCodeBar  = $dataToSendHacienda["totalAmount"];
        $montoPagarCodeBar  = str_replace(".", "", $montoPagarCodeBar);
        $montoPagarCodeBar  = str_pad($montoPagarCodeBar, 10, "0", STR_PAD_LEFT);

        /**** Numero NPE ***/
        $numCodeNpe = $returnServiceHacienda["data"];

        /**** Numeros Codigos de Barra ***/
        $numCodeBar             = $dataBarcodeNpe['preCodLoc'] . $dataBarcodeNpe['codLoc'] . $dataBarcodeNpe['preCantPagar'] . $montoPagarCodeBar . $dataBarcodeNpe['preFechaVenc'] . $dataBarcodeNpe['fechaVenc'] . $dataBarcodeNpe['preRefPago'] . $dataBarcodeNpe['referencia'] . $dataBarcodeNpe['correlativo'];
        $numCodeBarImpresion    = "(" . $dataBarcodeNpe['preCodLoc'] . ")" . $dataBarcodeNpe['codLoc'] . $dataBarcodeNpe['preCantPagar'] . $montoPagarCodeBar . $dataBarcodeNpe['preFechaVenc'] . $dataBarcodeNpe['fechaVenc'] . $dataBarcodeNpe['preRefPago'] . $dataBarcodeNpe['referencia'] . $dataBarcodeNpe['correlativo'];

        $codsBarNpe = array(
            "numCodeBar"    => $numCodeBar,
            "numNpe"        => $numCodeNpe,
            "numCodeBarImp" => $numCodeBarImpresion
        );

        return $codsBarNpe;
    }


    /***
     * Funcion para crear imagen de codigo de barra
     */

    function crearImageBarCodeNpe(array $dataBarcodeNpe, $order)
    {
        $builder = new Builder();
        $builder->setBarcodeType('gs1-128');
        $builder->setFilename("barcode_$order.png");
        $builder->setImageFormat('png');
        $builder->setWidth(360);
        $builder->setHeight(56);
        $builder->setFontSize(1);
        $builder->setBackgroundColor(255, 255, 255);
        $builder->setPaintColor(0, 0, 0);
        $builder->saveImage($dataBarcodeNpe['numCodeBarImp']);
    }

    /***
     * Funcion para unir codigo de barra
     */

    function crearPdfNpe(array $codeBar, array $dataToSendHacienda, array $dataBarcodeNpe, array $datosEntidad, $order, $insert_service_transaction)
    {

        /**
         * Dando Formato a Datos Necesaria
         */

        //NPE con espacios
        $diviendoNpe    = str_split($codeBar['numNpe'], 4);
        $npeConFormato  = implode(' ', $diviendoNpe);

        //NIT con guiones
        $nitConGuiones = "";
        for ($i = 0; $i < strlen($dataToSendHacienda['nit']); $i++) {
            if ($i == 3 || $i == 9 || $i == 12) {
                $nitConGuiones = $nitConGuiones . substr($dataToSendHacienda['nit'], $i, 1) . "-";
            } else {
                $nitConGuiones = $nitConGuiones . substr($dataToSendHacienda['nit'], $i, 1);
            }
        }

        $fechaHoraActual = Carbon::now()->format('Y/m/d g:i:s A');

        $datosFormateados = array(
                            "npeConFormato"     => $npeConFormato,
                            "nitConGuiones"     => $nitConGuiones,
                            "fechaHoraActual"   => $fechaHoraActual,
                            );
        
        /**
         * Generando PDF mandamiento
         */

        try{
            
            $pdf = App::make('dompdf.wrapper');
            $customPaper = array(0, 0, 654, 860);
            $pdf->setPaper($customPaper);
            $pdf->loadView('pdf.mandamiento_ingreso_nuevo', compact("codeBar", "dataToSendHacienda", "dataBarcodeNpe", "datosEntidad", "datosFormateados","order", "insert_service_transaction"))->save(storage_path() . "/app/mandamientos/mandamiento_$order.pdf");
            $b64Doc = base64_encode(file_get_contents( storage_path() . "/app/mandamientos/mandamiento_$order.pdf" ));
            
            return array(
                "exito"     => true,
                "pdfBase"   => $b64Doc,

            );

        }catch(Exception $e){

            return array(
                "exito"     => false,
                "pdfBase"   => $e->getMessage(),
            );

        }
      
    }
}
