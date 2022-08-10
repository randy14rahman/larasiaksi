<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Zend\Debug\Debug;

class SuratKeluarController extends Controller
{
    public function index()
    {

        $userModel = new User();

        // Debug::dump($userModel->getUserIsPettd());die;

        return view('surat-keluar.index', [
            'users_pettd' => $userModel->getUserIsPettd()
        ]);
    }

    public function addSurat(Request $request){
        // Debug::dump($request->input());die;

        if (!$_FILES){
            return response()->json(['status'=>false]);
        }
        $link_file = '';
        $allowedfileExtensions = array('pdf');
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = 'surat-keluar-' . md5(time() . $fileName);
        $dir = '/upload/surat-keluar/' . $newFileName . '.' . $fileExtension;
        $uploadFileDir = base_path() . '/public' . $dir;

        if (move_uploaded_file($fileTmpPath, $uploadFileDir)) {
            $link_file = $dir;
            // $message = 'File is successfully uploaded.';
        } else {
            $link_file = 'error';

            return response()->json([
                'status' => false
            ]);
            // $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
        }

        $params = [
            'tanggal_surat' => $request->input('tanggal_surat'),
            'perihal_surat' => $request->input('perihal'),
            'nomor_surat' => $request->input('nomor_surat'),
            'judul_surat' => $request->input('judul_surat'),
            'pettd' => (int) $request->input('pettd', 0),
            'pemaraf1' => (int) $request->input('pemaraf1'),
            'link_surat' => $link_file,
            'user_id' => (int) $request->input('user_id'),
        ];

        $additional_field = '';
        $additional_value = '';
        if (!is_null($request->input('pemaraf2'))){
            $additional_field = ',pemaraf2';
            $additional_value = ',:pemaraf2';
            $params['pemaraf2'] = (int) $request->input('pemaraf2');
        }
        // Debug::dump($params);die;

        $sql = "INSERT
                INTO
                surat_keluar (tanggal_surat,
                perihal_surat,
                nomor_surat,
                judul_surat,
                pettd,
                pemaraf1,
                link_surat,
                created_by{$additional_field})
            VALUES (:tanggal_surat,
            :perihal_surat,
            :nomor_surat,
            :judul_surat,
            :pettd,
            :pemaraf1,
            :link_surat,
            :user_id{$additional_value})";

        // Debug::dump($sql);
        // Debug::dump($params);die;

        app('db')->connection()->insert($sql, $params);

        return response()->json(['status'=>true]);
    }
}