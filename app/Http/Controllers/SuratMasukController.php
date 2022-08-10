<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Zend\Debug\Debug;
use Exception;

class SuratMasukController extends Controller
{
    public function index()
    {
        return view('surat-masuk.index');
    }

    public function addSuratMasuk(Request $request)
    {

        $link_file = '';
        if (isset($_FILES)) {
            $allowedfileExtensions = array('pdf');
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $fileType = $_FILES['file']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = 'surat-masuk-' . md5(time() . $fileName);
            $dir = '/upload/surat-masuk/' . $newFileName . '.' . $fileExtension;
            $uploadFileDir = base_path() . '/public' . $dir;

            if (move_uploaded_file($fileTmpPath, $uploadFileDir)) {
                $link_file = $dir;
                // $message = 'File is successfully uploaded.';
            } else {
                $link_file = 'error';

                return response()->json([
                    'transaction' => false
                ]);
                // $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
        };



        $params = [
            'tanggal_surat' => $request->input('tanggal_surat'),
            'asal_surat' => $request->input('asal_surat'),
            'nomor_surat' => $request->input('nomor_surat'),
            'assign_to' => $request->input('ditugaskan_ke'),
            'perihal_surat' => $request->input('perihal_surat'),
            'jenis_surat_masuk' => $request->input('jenis_surat_masuk'),
            'id_operator' => $request->input('user_id'),
            'link_file' => $link_file,
        ];

        $result = app('db')->connection()->insert("INSERT into surat_masuk (tanggal_surat,asal_surat,nomor_surat,assign_to,perihal_surat,jenis_surat_masuk,id_operator,link_file) VALUES(:tanggal_surat, :asal_surat,:nomor_surat,:assign_to, :perihal_surat, :jenis_surat_masuk, :id_operator, :link_file)", $params);


        return response()->json([
            'transaction' => true
        ]);
    }

    public function getSuratMasuk(Request $request)
    {

        try {
            $sql = "SELECT 
                    id_surat,
                    tanggal_surat, 
                    asal_surat,
                    perihal_surat,
                    nomor_surat,
                    CASE WHEN jenis_surat_masuk =0 THEN 'Biasa'
                    ELSE 'Penting' END as 'jenis_surat_masuk',
                    id_operator,
                    link_file,
                    is_disposisi,
                    is_proses,
                    is_arsip,
                    is_deleted,
                    created_date
             FROM surat_masuk";

            $data = app('db')->connection()->select($sql, []);

            $result = ['data' => $data];

            return response()->json($result);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}