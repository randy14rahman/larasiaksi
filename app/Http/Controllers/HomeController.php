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

        $sk_stats = app('db')->connection()->selectOne("select
        sum(case when nullif(is_ttd,0)=0 then 1 else 0 end) proses,
        sum(is_ttd) as arsip,
        sum(case when (nullif(is_paraf1,0)+nullif(is_paraf2,0))=0 then 1 else 0 end) draft,
        sum(case when (is_paraf1+is_paraf2)>0 then 1 else 0 end) paraf
        from surat_keluar");
        // Debug::dump($sk_stats);die;

        $tmp_sk_trendline = app('db')->connection()->select("select tanggal_surat, count(*) as jumlah from surat_keluar sk
        group by tanggal_surat order by tanggal_surat");
        // Debug::dump($sk_trendline);die;

        $sk_trendline = [];
        foreach ($tmp_sk_trendline as $k => $v) {
            $sk_trendline[] = [
                strtotime($v->tanggal_surat)*1000,
                $v->jumlah
            ];
        }
        // Debug::dump($sk_trendline);die;
        
        return view('home', [
            'data'=>[
                'surat_keluar' => [
                    'stats' => $sk_stats,
                    'trendline' => $sk_trendline
                ]
            ]
        ]);
    }
}