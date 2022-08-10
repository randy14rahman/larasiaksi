<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zend\Debug\Debug;

class ArsipController extends Controller
{
    public function index()
    {
        return view('arsip.index');
    }
}