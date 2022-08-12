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

    public function detail()
    {
        return view('surat-masuk.detail');
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

    public function getDetailSuratMasuk(Request $request)
    {
        $sql = 'SELECT id_surat,tanggal_surat,asal_surat
                        perihal_surat,
                        nomor_surat,
                        jenis_surat_masuk,
                        id_operator,
                        link_file,
                        assign_to,
                        is_disposisi,
                        is_proses,
                        is_arsip,
                        is_deleted,
                        created_date from surat_masuk where id_surat=:id_surat';
        $data = app('db')->connection()->selectOne($sql, ['id_surat' => $request->input('id_surat')]);

        $res = [
            'transaction' => true,
            'data' => $data
        ];
        return response()->json($res);
    }

    public function getListDisposisiAssign(Request $request)
    {
        $check_role_id = 'SELECT level from roles where id=:role_id';
        $level = app('db')->connection()->SelectOne($check_role_id, ['role_id' => $request->input('role_id')]);

        $where = 5;
        if ((int)$level->level == 3 || (int)$level->level == 4) {
            $where = 5;
        } else {
            $where = (int)$level->level + 1;
        }

        $sql = "SELECT users.id,users.name FROM `users` LEFT JOIN roles on users.role_id = roles.id where roles.level = :level";

        $data = app('db')->connection()->select($sql, ['level' => $where]);
        $res = [
            'transaction' => true,
            'data' => $data
        ];
        return response()->json($res);
    }

    public function getTrackingList(Request $request)
    {

        $data_list = [];
        $sql = "SELECT sm.id_surat, sm.is_proses,sm.is_disposisi,sm.is_arsip,sm.created_date as created_date,u.id as id_from,r.name as role_from,u.name as name_from, us.id as id_to, rs.name as role_to, us.name as name_to from `surat_masuk` sm 
        LEFT JOIN `users` u on sm.id_operator = u.id 
        LEFT JOIN `roles` r on u.role_id = r.id
        LEFT JOIN `users` us on sm.assign_to = us.id 
        LEFT JOIN `roles` rs on us.role_id = rs.id
        WHERE sm.id_surat=:id_surat";
        $data = app('db')->connection()->selectOne($sql, ['id_surat' => $request->input('id_surat')]);

        $data_list[] = [
            'status' => 'Surat Masuk',
            'id' => $data->id_from,
            'name' => $data->name_from,
            'role' => $data->role_from,
            'date' => $data->created_date
        ];

        $to_process = NULL;
        $date_process = '';
        if ($data->is_disposisi == NULL && $data->is_proses == 1) {
            $sql_cek = "SELECT psm.tanggal_proses FROM `surat_masuk` sm LEFT JOIN proses_surat_masuk psm on sm.id_surat = psm.id_surat WHERE sm.id_surat = :id_surat";
            $process = app('db')->connection()->selectOne($sql_cek, ['id_surat' => $request->input('id_surat')]);
            $to_process = $data->is_proses;
            $date_process = $process->tanggal_proses;
        }


        $data_list[] = [
            'status' => 'Disposisi 1',
            'id' => $data->id_to,
            'name' => $data->name_to,
            'role' => $data->role_to,
            'date' => $date_process,
            'proses' => $to_process
        ];

        if ($data->is_disposisi != NULL) {
            // Debug::dump($data->is_disposisi);
            // die();
        }

        $res = ['transaction' => true, 'data' => $data_list];
        return response()->json($res);
    }

    public function processSurat(Request $request)
    {
        $id_surat  = $request->input('id_surat');
        $user_id = $request->input('user_id');


        $sql = "UPDATE `surat_masuk` SET is_proses = 1 where id_surat=:id_surat";

        app('db')->connection()->update(
            $sql,
            ['id_surat' => $id_surat]
        );

        $sql_get = "SELECT is_disposisi from surat_masuk where id_surat=:id_surat";
        $dataa = app('db')->connection()->selectOne($sql_get,  ['id_surat' => $id_surat]);


        //INSERT TO TABLE Surat Proses
        $data_params = [
            'id_surat' => $id_surat,
            'tanggal_proses' => date("Y-m-d"),
            'id_pemroses' => $user_id,
        ];

        app('db')->connection()->insert("INSERT INTO proses_surat_masuk (id_surat,tanggal_proses,id_pemroses) VALUES(:id_surat, :tanggal_proses, :id_pemroses)", $data_params);


        if ($dataa->is_disposisi !== NULL) {
            $sql_update = "UPDATE `disposisi_surat_masuk` SET is_selesai=1 WHERE id_surat=:id_surat and target_disposisi=:id_user";
            app('db')->connection()->update(
                $sql_update,
                [
                    'id_surat' => $id_surat,
                    'user_id' => $user_id
                ]
            );
        }
        $res = [
            "transaction" => true
        ];
        return response()->json($res);
    }

    public function disposisiSurat(Request $request)
    {
        $id_surat  = $request->input('id_surat');
        $assign_to = $request->input('assign_to');
        $user_id = $request->input('user_id');


        //UPDATE SURAT MASUK 
        $sql = 'UPDATE `surat_masuk` set is_disposisi = 1 where id_surat=:id_surat';
        app('db')->connection()->update(
            $sql,
            ['id_surat' => $id_surat]
        );

        //INSERT DISPOSISI SURAT MASUK
        $params = [
            'id_surat' => $id_surat,
            'source_disposisi' => $user_id,
            'target_disposisi' => $assign_to,
            'tanggal_disposisi' => date("Y-m-d"),
        ];

        app('db')->connection()->insert("INSERT INTO disposisi_surat_masuk (id_surat,source_disposisi,target_disposisi,tanggal_disposisi) VALUES(:id_surat, :source_disposisi, :target_disposisi,:tanggal_disposisi)", $params);


        $res = [
            'transaction' => true
        ];
        return response()->json($res);
    }
}