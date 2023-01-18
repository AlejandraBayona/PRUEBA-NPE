<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Implementation\UserServiceImpl;

class UserController extends Controller
{
    /**
     * @var UserServiceImpl
     * 
     */
    private $userService;

    /**
     * @var Request
     */
    private $request;

    public function __construct(UserServiceImpl $userService, Request $request)
    {
        $this->userService = $userService;
        $this->request = $request;
    }

    function getInfoUser(){


        $response = response("", 203);

        $return_service = $this->userService->postUser($this->request->all());

        $response = response($return_service, 200);

        return $response;
    }

}
