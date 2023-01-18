<?php


use PHPMailer\PHPMailer\Exception;

require 'inc/Exception.php';
include "inc/Logs.php";
date_default_timezone_set('America/El_Salvador');


//$log = new Logs("log" . time(), getcwd() . "//");
//$log->insert('// ********************************************************** //', false, false, false);
//$log->insert('Iniciando el proceso de verificacion de pagos', false, false, false);

//PRIMERO OBTENDRE LOS CORREOS A LOS QUE LES ENVIARE EL AVISO

//Datos de Acceso A BD
$host_wp = 'goes-prod-mysql.cnysi0ldpq0y.ca-central-1.rds.amazonaws.com';
$user_wp = 'npe';
$pass_wp = 'dBhVhTsg2M2XfMwk';
$db_wp   = 'npe';


/**
 * Verificare conexion a base de datos
 */

$mysqli = new mysqli($host_wp, $user_wp, $pass_wp, $db_wp);

$mysqli->set_charset("utf8");

if ($mysqli->connect_error) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    //$log->insert('Error en la conexion a la base de datos', false, false, false);
    exit;
}

/**
 * Lo primero que hare es conectarme a servicio MH
 */
$lotes = 20000; 
$results = connect_service_mh($lotes);


if (!$results["error"]) {

    if($results["error"] == true){
        //$log->insert("Error viene como true", false, false, false);
        exit;
    }

    if ($results["data"] == NULL) {
        //$log->insert("Respuesta data viene como NULL en calculo de peticiones", false, false, false);
        exit;
    }

    if(!isset($results["size"])){
        //$log->insert("Variable size indefinida", false, false, false);
        exit;
    }

    $size = intval($results["size"]);
    echo "size : " . $size;
    $num_peticiones = ceil($size / $lotes);
    //$log->insert('Calculo de numero de peticiones resulto: ' . $num_peticiones, false, false, false);
    for($i = 0; $i < $num_peticiones; $i++){
        //$log->insert('*******************************************************', false, false, false);
        //$log->insert('Iniciando Iteracion: ' . $i, false, false, false);
        $npe_payments = array();
        $numbers_npe_payments = array();

        $url_server = "https://dgt.mh.gob.sv/";
        $url = $url_server . "serviciosdgt/security/api/v1/paids?df=npe&op=$i&lp=$lotes";
        $ch = curl_init($url);

        $authorization = "Authorization:eyJzdWIiOiI2MyIsImF1ZCI6InNlcnZpY2lvc2RndCIsInN0YSI6MSwiaXNzIjoiTUgiLCJuYW1lIjoiZW50aXR5NjMiLCJleHAiOjE3MDQzOTM2NDcwMDAsImlhdCI6MTY3Mjg1NzY0NzAwMH0.KiIENUFAQ1BVckUoHhcBQGFvQGpGKggUQFVcQFshQGBHMCNXQVJzUEU7OmSk";
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => array(
                $authorization
            ),
            CURLOPT_SSL_VERIFYPEER => false,
        );
        
        curl_setopt_array($ch, $options);
        $resp = curl_exec($ch);
        curl_close($ch);
	echo "llegue";

        $response_data = json_decode($resp, true);
        if($response_data["error"] == true){
            //$log->insert("Error viene como true", false, false, false);
            continue;
        }
    
        if ($response_data["data"] == NULL) {
            //$log->insert("Respuesta data viene como NULL", false, false, false);
            continue;
        };

        $response_data = $response_data["data"];
        
        foreach ($response_data as $key => $value) {
            $rest = substr($value["document"],23,2);
            //verificando que el npe sea de origen 63 MINSAL
            if($rest === "63"){
                //codigo minsal por lo tanto este npe si debo verficarlo
                $date_format_mysql = date("Y-m-d H:i:s");
                $npe_payments[] = array(
                    "npe"               => $value["document"],
                    "created_at"        => $date_format_mysql,
                    "num_comprobante"   => $value["cashierCode"],
                );
                $numbers_npe_payments[] = $value["document"];
            }
        }


        $json_parameter = "";
        $json_parameter = json_encode($npe_payments);

	//Si el proceso de actualizacion en BD se ejecuta correctamente pasare bandera a true
        // y eso significara que puedo procesar los pagos en MH
        $flag_update_success = false;

        //Mando json de npe encontrando a Base de DATOS para actualizcion
        try {
            if ($call = $mysqli->prepare("CALL sp_jsonTest(?)")) {

                $bind_parram = $call->bind_param('s', $json_parameter);
                $ex = $call->execute();
                if (false === $ex) {
                    //$log->insert('Error en ejecucion de procedimiento', false, false, false);
                    //$log->insert("execute() failed: " . htmlspecialchars($call->error), false, false, false);
                }else{
                    //EXEC DE PROCEDIMIENTO FUE EXITOSO
                    echo "cool";
			$flag_update_success = true;
                }
                $call->close();
            } else {
                 //$log->insert('Error en respuesta de ejecucion de procedimiento', false, false, false);
            }
        } catch (Exception $e) {
    
            //$log->insert('Error al Actualizar datos en BD', false, false, false);
            return false;
        }

        //$log->insert('Finalizando Actualizacion en Base De Datos ITERACION: ' . $i, false, false, false);

        if($flag_update_success){

            $sql_npe = "SELECT t.npe, c.nit, i.codigo_solicitud FROM transactions t 
                        INNER JOIN payments p 
                        ON p.transaction_id = t.id 
                        INNER JOIN contributors c 
                        ON c.transaction_id = t.id 
			INNER JOIN invoices i
			on i.transaction_id = t.id
                        WHERE p.estado = 1
                        AND t.npe IN (". "'" . implode("','", $numbers_npe_payments) . "');";

            $results_q = array();
            $results_q = $mysqli->query($sql_npe); 
	    $datosEnvioArray = [];

            if($results_q){
                if ($results_q->num_rows > 0) {
                    while ($row = $results_q->fetch_assoc()) {
                        
                        //actualizare como procesado en MH
                        try {
                            $url_server = "https://dgt.mh.gob.sv/";
                            $url = $url_server . "serviciosdgt/security/api/v1/users/" . $row['nit'] . "/documents/" . $row['npe'] . "?df=npe";
                            $ch = curl_init($url);
                            $authorization = "Authorization:eyJzdWIiOiI2MyIsImF1ZCI6InNlcnZpY2lvc2RndCIsInN0YSI6MSwiaXNzIjoiTUgiLCJuYW1lIjoiZW50aXR5NjMiLCJleHAiOjE3MDQzOTM2NDcwMDAsImlhdCI6MTY3Mjg1NzY0NzAwMH0.KiIENUFAQ1BVckUoHhcBQGFvQGpGKggUQFVcQFshQGBHMCNXQVJzUEU7OmSk";
                            $options = array(
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_CUSTOMREQUEST => "PATCH",
                                CURLOPT_POSTFIELDS => [],
                                CURLOPT_HTTPHEADER => array(
                                    $authorization
                                ),
                                CURLOPT_SSL_VERIFYPEER => false,
                            );
                    
                            curl_setopt_array($ch, $options);
                            $resp = curl_exec($ch);
                            curl_close($ch);
                            
                            $results = json_decode($resp, true);

                            if(!isset($results["error"]) ){
                                //$log->insert('Error indefinido para update' . $row['npe'], false, false, false);
                                continue;
                            }
                            if($results["error"] === true){
                                //$log->insert('Error igual true para ' . $row['npe'], false, false, false);
                                //$log->insert('Message :' . $results["message"], false, false, false);
                                continue;
                            }

			   $datosEnvioArray[] = array(
				"npe" => $row['npe'],
				"codigoSolicitud" => $row['codigo_solicitud'],
				);

                        } catch (Exception $e) {
                            //$log->insert('Error al conectarse a servicio MH en update a procesado', false, false, false);
                        }
                    }
                }else{
                    //$log->insert('num rows en iteracion ' . $i, false, false, false);
                }
		
                //Conectandose a servicio de Permisos de Funcionamiento Para actualizar pagados

                $url = 'https://tramitesadmin.salud.gob.sv/api/actualizacion_pagos';

                //url-ify the data for the POST
                $fields_string = http_build_query($datosEnvioArray);

                //open connection
                $ch = curl_init();

                //set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                echo "Resultado conexion \n";
                //execute post
                $result = curl_exec($ch);

                //close connection
                curl_close($ch);

                var_dump($result);

            }else{
                //$log->insert('result false en iteracion ' . $i, false, false, false);
            }
        }

    }

    //$log->insert('Se finalizo proceso de actualizacion de pagos.', false, false, false);

    /* close connection */
    $mysqli->close();
}

function connect_service_mh($lotes)
{
    /****
     *
     * Consumiendo with curl
     */
    try {
        $url_server = "https://dgt.mh.gob.sv/";
        $url = $url_server . "serviciosdgt/security/api/v1/paids?df=npe&op=0&lp=$lotes";

        $ch = curl_init($url);

        $authorization = "Authorization:eyJzdWIiOiI2MyIsImF1ZCI6InNlcnZpY2lvc2RndCIsInN0YSI6MSwiaXNzIjoiTUgiLCJuYW1lIjoiZW50aXR5NjMiLCJleHAiOjE3MDQzOTM2NDcwMDAsImlhdCI6MTY3Mjg1NzY0NzAwMH0.KiIENUFAQ1BVckUoHhcBQGFvQGpGKggUQFVcQFshQGBHMCNXQVJzUEU7OmSk";
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => [],
            CURLOPT_HTTPHEADER => array(
                $authorization
            ),
            CURLOPT_SSL_VERIFYPEER => false,
        );

        curl_setopt_array($ch, $options);
        $resp = curl_exec($ch);
        curl_close($ch);
        // echo $resp;

        $results = json_decode($resp, true);
        return $results;
        
    } catch (Exception $e) {
        //$log->insert('Error al conectarse a servicio MH', false, false, false);
        return false;
    }
}
