<?php
    namespace App\Services\Interfaces;

    interface INpeServiceInterface {

        /**
         * @param array $data_request
         * @return bool
         */
        function validateData(array $data_request);

        /**
         * @param array $npe
         * @return array data
         */
        function dataCreateMh(array $npe, array $services);

        /**
         * @param array $npe
         * @return array data MH
         */
        function postNpe(array $npe);


        /**
         * @param int $npe
         * @return array data mandamiento MH
         */
        function getIndvMand($mandamiento, $uri);


        /**
         * @param array $data_user
         * @return array response
         */
        function validateDataRequest(array $data_user);

        
        /** 
         * @param array $data_request
         * @return array 0 => code bar , 1 => npe
         */
        function createCodeBarNpe(array $data_request, array $taxes);



    }