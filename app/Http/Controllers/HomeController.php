<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('dashboard');
    }

    public function chart() {
        return view('chart');
    }

    public function test() {
        return view('test');
    }
}
