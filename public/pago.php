<?php

    /****
         * 
         * Consumiendo with curl
         */
        if( !isset($_GET["npe"]) ){
            $npe = "";
        }else{
            $npe = $_GET["npe"];
        }

        $url = "https://test7.mh.gob.sv/dgtserfinsa/rnwy?npe=$npe";
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
        
        $ruta = "https://test7.mh.gob.sv/dgtserfinsa/";
        $format = str_replace("/dgtserfinsa/", "https://test7.mh.gob.sv/dgtserfinsa/", $resp);
            
        echo $format;

        exit;