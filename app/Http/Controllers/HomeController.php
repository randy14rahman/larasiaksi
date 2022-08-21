<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
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

        $sk_stats = app('db')->connection()->selectOne("SELECT
            sum(case when is_ttd is null then 1 else 0 end) proses,
            sum(case when is_ttd=1 then 1 else 0 end) as arsip,
            sum(case when is_paraf1 is null or (pemaraf2 is not null and is_paraf2 is null) then 1 else 0 end) draft,
            sum(case when (is_paraf1=1 or (pemaraf2 is not null and is_paraf2=1)) and is_ttd is null  then 1 else 0 end) paraf
        from
            surat_keluar");
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

        $sm_stats = (new SuratMasuk())->getStatistik();
        $sm_trendline = (new SuratMasuk())->getTrendline();
        
        return view('home', [
            'data'=>[
                'surat_keluar' => [
                    'stats' => $sk_stats,
                    'trendline' => $sk_trendline
                ],
                'surat_masuk' => [
                    'stats' => $sm_stats,
                    'trendline' => $sm_trendline
                ]
            ]
        ]);
    }
}