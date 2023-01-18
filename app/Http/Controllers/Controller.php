<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function response ($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}
