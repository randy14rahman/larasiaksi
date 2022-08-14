<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Zend\Debug\Debug;
use Exception;

class NotificationController extends Controller
{
    public function index(Request $request)
    {

        // Debug::dump(auth()->id());die;


        $sql = "SELECT  sm.id,
        sm.tanggal_surat,
        sm.nomor_surat,
        sm.created_at,
        'surat-masuk' as jenis
     FROM surat_masuk sm LEFT JOIN disposisi_surat_masuk dsm on sm.id= dsm.id_surat where (sm.is_proses IS NULL) AND (sm.assign_to=:user_id OR dsm.target_disposisi=:user_id2)  order by sm. created_at  DESC";

        $data = app('db')->connection()->select($sql, [
            'user_id' => auth()->id(),
            'user_id2' => auth()->id()
        ]);

        $sql = "SELECT sk.id, sk.perihal_surat, sk.pemaraf1, sk.pemaraf2, sk.pettd, u.name as created_by_name, sk.created_at
            from surat_keluar sk 
            left join users u on sk.created_by=u.id
            where (is_ttd is null or is_ttd=0) and (sk.pemaraf1=:pemaraf1 or sk.pemaraf2=:pemaraf2 or sk.pettd=:pettd) order by sk.created_at";

        $surat_keluar = app('db')->connection()->select($sql,[
            'pemaraf1' => auth()->id(),
            'pemaraf2' => auth()->id(),
            'pettd' => auth()->id(),
        ]);

        return response()->json([
            'transaction' => true,
            'count' => count($data),
            'data' => $data,
            'surat_keluar'=>[
                'data' => $surat_keluar,
                'count'=> count($surat_keluar)
            ]
        ]);
    }
}