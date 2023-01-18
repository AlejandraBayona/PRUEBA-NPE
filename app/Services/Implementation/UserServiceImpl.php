<?php

namespace App\Services\Implementation;

use App\Services\Interfaces\IUserServiceInterface;


class UserServiceImpl implements IUserServiceInterface{
    /***
     * Implementara funciones de validaciones de datos
     *
     */ 
    function postUser(array $user){
        // print_r($user);
        return $user;
    }

}