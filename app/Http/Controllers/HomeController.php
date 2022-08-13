<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zend\Debug\Debug;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $sk_stats = app('db')->connection()->select("select
        sum(case when is_ttd is null then 1 else 0 end) proses,
        sum(is_ttd) as arsip,
        sum(case when (ifnull(is_paraf1,0)+ifnull(is_paraf2,0))=0 then 1 else 0 end) draft,
        sum(case when (is_paraf1+is_paraf2)>0 then 1 else 0 end) paraf
        from surat_keluar");
        // Debug::dump($sk_stats);die;

        return view('home', [
            'data' => [
                'surat_keluar' => $sk_stats
            ]
        ]);
    }
}