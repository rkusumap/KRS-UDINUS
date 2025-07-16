<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseApi;


class KRSController
{
    public function krs_current($nim) {
        
        $nim = md5($nim);
        dd(auth()->user());

    }

}
