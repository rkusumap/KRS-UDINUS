<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseApi;

class KRSController extends Controller
{
    public function tes(Request $request) {

        return ResponseApi::success();
    }
}
