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

        $params = [];
        $sWhere = "";
        if (in_array(auth()->user()->role_id, [2,3,4,5,6,7])) {
            $params = [
                'created_by' => auth()->user()->id,
                'pemaraf1' => auth()->user()->id,
                'pemaraf2' => auth()->user()->id,
                'pettd' => auth()->user()->id,
            ];
            $sWhere .= " and (created_by=:created_by or pemaraf1=:pemaraf1 or pemaraf2=:pemaraf2 or pettd=:pettd) ";
        }

        $sk_stats = app('db')->connection()->selectOne("SELECT
            sum(case when is_ttd is null then 1 else 0 end) proses,
            sum(case when is_ttd=1 then 1 else 0 end) as arsip,
            sum(case when is_paraf1 is null or (pemaraf2 is not null and is_paraf2 is null) then 1 else 0 end) draft,
            sum(case when (is_paraf1=1 or (pemaraf2 is not null and is_paraf2=1)) and is_ttd is null  then 1 else 0 end) paraf
        from
            surat_keluar where 1=1{$sWhere}", $params);
        // Debug::dump($sk_stats);die;

        $tmp_sk_trendline = app('db')->connection()->select("SELECT tanggal_surat, count(*) as jumlah 
        from surat_keluar sk
        where 1=1{$sWhere}
        group by tanggal_surat order by tanggal_surat", $params);
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