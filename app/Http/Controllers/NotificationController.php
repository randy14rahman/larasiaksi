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


        $sql = "SELECT  sm.id,
        sm.tanggal_surat,
        sm.nomor_surat,
        sm.created_at,
        'surat-masuk' as jenis
     FROM surat_masuk sm LEFT JOIN disposisi_surat_masuk dsm on sm.id= dsm.id_surat where (sm.is_proses IS NULL) AND (sm.assign_to=:user_id OR dsm.target_disposisi=:user_id2)  order by sm. created_at  DESC";

        $data = app('db')->connection()->select($sql, [
            'user_id' => $request->input('user_id'),
            'user_id2' => $request->input('user_id')


        ]);

        return response()->json([
            'transaction' => true,
            'count' => count($data),
            'data' => $data
        ]);
    }
}