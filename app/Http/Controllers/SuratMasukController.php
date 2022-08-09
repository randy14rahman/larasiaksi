<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zend\Debug\Debug;

class SuratMasukController extends Controller
{
    public function index()
    {
        return view('surat-masuk.index');
    }

    public function addSuratMasuk(Request $request)
    {
        Debug::dump($request->input());

        Debug::dump($_FILES);
        die;
    }
}