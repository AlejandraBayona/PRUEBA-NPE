<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PagoController extends Controller
{

    public function creacion_pdf_comprobante_pago($data)
    {
        $num = "001";
        $webRoot = "C:/Users/orell/Desktop/NPE/PROYECTOS/lumen/";
        $pdf = App::make('dompdf.wrapper');
        $customPaper = array(0, 0, 654, 860);
        $pdf->setPaper($customPaper);
        $pdf->loadView('pdf.comprobante_pago', compact("data"));
        return $pdf->stream('comprobante_pago.pdf');

    } // EndFunction @creacion_pdf_comprobante_pago

    public function get_data_transaction($npe)
    {
        $transaction = Transaction::select(DB::raw('DATE_FORMAT(payments.created_at, "%d/%m/%Y") as date_pay, transactions.total_pagar'))
            ->join('payments', 'transactions.id', 'payments.transaction_id')
            ->where('npe', '=', $npe)
            ->first();

        return $transaction;
    }



    public function download_comprobante_pago()
    {
        try {
            if (!isset($_GET["npe"])) {
                return view('npe.error_pago', []);
                exit;
            } else {
                $npe = $_GET["npe"];
            }

            $base_url = env('URL_MH_BASE_DEV');
            $url_especifica_serfinsa = "/dgtserfinsa/rnwyc?npe=" . $npe;
            $url_especifica_hacienda = "/serviciosdgt/security/api/v1/paids/" . $npe;
            $mytime = Carbon::now('America/El_Salvador');
            $current_date = $mytime::now()->format('d/m/Y H:i');

            /**
             * Primero consultare el estado que tiene en MH
             */

            $response_api_mh = Http::withHeaders([
                'Authorization' => env('TOKEN_MH_DEV')
            ])->get($base_url . $url_especifica_hacienda);

            $respuesta_mh =  json_decode($response_api_mh->body(), true);

            if ($respuesta_mh["error"] == false) {

                if ($respuesta_mh["data"] != null) {

                    if ($respuesta_mh["data"]['message'] === "Mandamiento pagado") {
                        //Descargare pdf de comprobante
                        
                        $monto_pagar = $this->get_data_transaction($npe);
                        $data_comprobante = array(
                            "npe"                   => $respuesta_mh["data"]['document'],
                            "fecha_pago"            => $monto_pagar->date_pay,
                            "monto_total"           => $monto_pagar->total_pagar,
                            "numero_autorizacion"   => $respuesta_mh["data"]['transaction'],
                            "current_date"          => $current_date
                        );

                        return $this->creacion_pdf_comprobante_pago($data_comprobante);
                        exit;
                        
                    } elseif ($respuesta_mh["data"]['message'] === "Mandamiento pagado y procesado") {
                        //Descargare pdf de comprobante
                        $monto_pagar = $this->get_data_transaction($npe);

                        $data_comprobante = array(
                            "npe"                   => $respuesta_mh["data"]['document'],
                            "fecha_pago"            => $monto_pagar->date_pay,
                            "monto_total"           => $monto_pagar->total_pagar,
                            "numero_autorizacion"   => $respuesta_mh["data"]['transaction'],
                            "current_date"          => $current_date
                        );

                        return $this->creacion_pdf_comprobante_pago($data_comprobante);
                        exit;
                    }
                }
            } 


            /**
             * Segundo consultare el estado que tiene en serfinsa
             */

            $response_api_serfinsa = Http::get($base_url . $url_especifica_serfinsa);
            $respuesta_serfina = json_decode($response_api_serfinsa->body(), true);

            if ($respuesta_serfina['satisFactorio'] == true && $respuesta_serfina['mensaje'] == "Autorizado") {
                //Descargar comprobante
                $monto_pagar = $this->get_data_transaction($npe);
                $data_comprobante = array(
                    "npe"                   => $npe,
                    "fecha_pago"            => $monto_pagar->date_pay,
                    "monto_total"           => $respuesta_serfina["monto"],
                    "numero_autorizacion"   => $respuesta_serfina["numeroAutorizacion"],
                    "current_date"          => $current_date
                );
                return $this->creacion_pdf_comprobante_pago($data_comprobante);


                exit;
            }
            exit;
        } catch (\Exception $e) {
            dd($e);
            return view('npe.error_pago', []);
            exit;
        }
    } // EndFunction @download_comprobante_pago


    public function index()
    {
        try {
            if (!isset($_GET["npe"])) {
                return view('npe.error_pago', []);
                exit;
            } else {
                $npe = $_GET["npe"];
            }

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
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["acceso"] = time();

            $base_url = env('URL_MH_BASE_DEV');;
            $url_especifica_serfinsa = "/dgtserfinsa/rnwyc?npe=" . $npe;
            $url_especifica_hacienda = "/serviciosdgt/security/api/v1/paids/" . $npe;

            /**
             * Primero consultare el estado que tiene en MH
             */

            $response_api_mh = Http::withHeaders([
                'Authorization' => env('TOKEN_MH_DEV')
            ])->get($base_url . $url_especifica_hacienda);

            $respuesta_mh =  json_decode($response_api_mh->body(), true);

            if ($respuesta_mh["error"] == false) {

                if ($respuesta_mh["data"] != null) {

                    if ($respuesta_mh["data"]['message'] === "Mandamiento pagado") {
                        //Descargare pdf de comprobante
                        return view('npe.pago_realizado', ["number_npe" => $npe]);
                        exit;
                    } elseif ($respuesta_mh["data"]['message'] === "Mandamiento pagado y procesado") {
                        //Descargare pdf de comprobante
                        return view('npe.pago_realizado', ["number_npe" => $npe]);
                        exit;
                    }
                }
            }


            /**
             * Segundo consultare el estado que tiene en serfinsa
             */

            $response_api_serfinsa = Http::get($base_url . $url_especifica_serfinsa);
            $respuesta_serfina = json_decode($response_api_serfinsa->body(), true);

            if ($respuesta_serfina['satisFactorio'] == true && $respuesta_serfina['mensaje'] == "Autorizado") {
                //Descargar comprobante

                return view('npe.pago_realizado',  ["number_npe" => $npe]);
                exit;
            }

            /****
             * 
             * Consumiendo with curl ventana para pago
             */


            $url = $base_url . "/dgtserfinsa/rnwy?npe=$npe";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

            $headers = array();

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, '');
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);
            $url_base = env('URL_MH_BASE_DEV_S');
            $ruta = $url_base . "dgtserfinsa/";
            $format = str_replace("/dgtserfinsa/", $ruta, $resp);

            echo $format;

            exit;
        } catch (\Exception $e) {
            return view('npe.error_pago', []);
            exit;
        }
    } // EndFunction @index

}// EndClass PagoController
