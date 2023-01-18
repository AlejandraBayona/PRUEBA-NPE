<?php

namespace App\Services\Implementation;

use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\INpeServiceInterface;


class NpeServiceImpl implements INpeServiceInterface{

    /***
     * Implementara funciones de validaciones de datos de request
     *
     */
    function validateDataRequest(array $data_request){
/***
         * Verificando que ningun valor sea null o indefinido
         */
        if( !isset($data_request['numberNit']) || !isset($data_request['inputLastName'])  || !isset($data_request['valueService'])  || !isset($data_request['servicio']) || 
            !isset($data_request['entidadId']) || !isset($data_request['inputFirstName']) ){
            
                $return_service = array(
                    "error"   => true, 
                    "message"   => "Valores Indefinidos en datos ingresados",
                    "data"      => array()  
                );

                return $return_service;

        }

        /***
         * Verificando que ningun valor sea string vacio
         */
        if( $data_request['numberNit'] === "" || $data_request['inputLastName'] === "" || $data_request['valueService'] === "" || $data_request['servicio'] === "" ||  
            $data_request['entidadId'] === ""){

                $return_service = array(
                    "error"   => true, 
                    "message"   => "Valores vacios, complete los datos",
                    "data"      => array()  
                );

                return $return_service;

        }

        if($data_request['tipoContribuyente'] == 1){

            if( $data_request['inputFirstName'] === ""){
                $return_service = array(
                    "error"   => true, 
                    "message"   => "Valores vacios, complete los datos",
                    "data"      => array()  
                );

                return $return_service;
            }

        }
       
        $return_service = array(
            "error"   => false, 
            "message"   => "Todo bien en validacion",
            "data"      => array()  
        );

        return $return_service;
    }

    

    /***
     * Implementara funciones de validaciones de datos
     *
     */ 
    function validateData(array $npe){

        /***
         * Verificando que ningun valor sea null o indefinido
         */
        if( !isset($npe['montoPagar']) || !isset($npe['referencia']) || !isset($npe['numberNit']) || 
            !isset($npe['cuentaCont']) || !isset($npe['dueDate']) || !isset($npe['period']) || !isset($npe['username']) || 
            !isset($npe['inputFirstName']) || !isset($npe['inputLastName']) ){
            
                $return_service = array(
                    "error"   => true, 
                    "message"   => "Valores Indefinidos para creacion de NPE",
                    "data"      => array()  
                );

                return $return_service;

        }

        /***
         * Verificando que ningun valor sea string vacio
         */
        if( $npe['montoPagar'] === "" || $npe['referencia'] === "" || $npe['numberNit'] === "" ||  
            $npe['cuentaCont'] === "" || $npe['dueDate'] === "" || $npe['period'] === "" || $npe['username'] === "" || 
            $npe['inputLastName'] === "" ){

                $return_service = array(
                    "error"   => true, 
                    "message"   => "Valores vacios para creacion de NPE",
                    "data"      => array()  
                );

                return $return_service;

        }
       
        $return_service = array(
            "error"   => false, 
            "message"   => "Todo bien en validacion",
            "data"      => array()  
        );

        return $return_service;
    }


    /***
     * Implementara funcion para crear NPE y data para enviar a servicio MH
     *
     */ 
    function dataCreateMh(array $npe, array $services){

        $send_data_mh = array(
            "nit"           => $npe['numberNit'],
            "document"      => $npe['referencia'] . $npe['correlativo'],
            "account"       => $npe['cuentaCont'],
            "dueDate"       => $npe['dueDate'],
            "period"        => $npe['period'],
            "userAccount"   => $npe['username'],
            "firstName"     => $npe['inputFirstName'],
            "lastName"      => $npe['inputLastName'],
            "taxCode"       => "41202",
            "totalAmount"   => "" . number_format($npe['montoPagar'],2,'.','') . "",
            "concept"       => "Pagos varios de fae ministerio de salud publica y asistencia social",
            "taxes"         => array(
                array(
                    "code" => "41202",
                    "amount" => number_format($npe['montoPagar'],2,'.','')
                )
            )
        );

        return $send_data_mh;
    }


    /***
     * Funcion para conectarse a API MH
     *
     */ 
    function postNpe(array $npe){


        try{
            $url_base = env('URL_MH_BASE_DEV_S');

            $url = $url_base . "serviciosdgt/security/api/v1/documents?df=npe";
            
            $response = Http::withHeaders([
                'Authorization' => env('TOKEN_MH_DEV')
            ])->post($url, $npe);
            
            return $response->json();

        }catch(\Exception $e){

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
    function createCodeBarNpe(array $data_request, array $taxes){

        


        /**Creando String  num code bar */
        $data_request['valor_format'] = number_format($data_request['montoPagar'],2,'.','');
        $data_request['valor_format'] = (string) $data_request['valor_format'];
        $data_request['valor_format'] = str_replace(".", "", $data_request['valor_format']);
        $data_request['valor_format'] = str_pad($data_request['valor_format'], 10, "0", STR_PAD_LEFT);

        $num_code_bar = $data_request['pre_cod_loc'] . $data_request['cod_loc'] . $data_request['pre_cant_pagar'] . $data_request['valor_format'] . $data_request['pre_fecha_venc'] . $data_request['fechaVenc'] . $data_request['pre_ref_pago'] . $data_request['referencia'] . $data_request['correlativo']; 

        $num_code_npe = $data_request['codigo_loc_mh'] . $data_request['valor_format'] . $data_request['fechaVenc'] . $data_request['comodin'] . $data_request['referencia'] . $data_request['correlativo'];
        
        $num_code_bar_impresion = "(" . $data_request['pre_cod_loc'] . ")" . $data_request['cod_loc'] . $data_request['pre_cant_pagar'] . $data_request['valor_format'] . $data_request['pre_fecha_venc'] . $data_request['fechaVenc'] . $data_request['pre_ref_pago'] . $data_request['referencia'] . $data_request['correlativo'];
        /** Calculo de dato verificador */
        $p = $num_code_npe;
        $sum = 0;
        $p=str_replace(" ", "", $p);
        $d=str_split($p,1); //Ejemplo 

        for ($i=0; $i<strlen($p); $i+=2) {
            $sum += ($d[$i]*2) + (($d[$i]>4)?1:0) + (($i>0)?$d[$i-1]:0);
        }

        $VR= ((10-($sum % 10 )) % 10);

        $num_code_npe = $num_code_npe . $VR;

        $cods_bar_npe = array(
                        "num_code_bar"      => $num_code_bar,
                        "num_npe"           => $num_code_npe,
                        "num_code_bar_imp"  => $num_code_bar_impresion
                    );

        return $cods_bar_npe;
    }










    /**
     * Consulta Mandamiento
     * 
     */

    function validateDataMandamiento(array $mandamiento){

        if( !isset($mandamiento['numberMandamiento']) ){
            
            $return_service = array(
                "error"   => true, 
                "message"   => "Valor indefinido para consulta de NPE",
                "data"      => array()  
            );
            
            return $return_service;
        }

        if( $mandamiento['numberMandamiento'] == ""){
            $return_service = array(
                "error"   => true, 
                "message"   => "Valor vacio para consulta de NPE",
                "data"      => array()  
            );

            return $return_service;
        }

        $return_service = array(
            "error"   => false, 
            "message"   => "Valor vacio para consulta de NPE",
            "data"      => array()  
        );

        return $return_service;

    }




    /***
     * Funcion para conectarse a API MH 
     * y obtener informacion de un mandamiento especifico
     *
     */
    function getIndvMand($mandamiento, $uri){
        
        // $response_api_mh = Http::get("https://jsonplaceholder.typicode.com/todos/1");
    

        // dd($response->json());

    }


    

}