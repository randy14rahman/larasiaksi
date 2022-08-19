<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SuratMasuk;
use Zend\Debug\Debug;
use Exception;

date_default_timezone_set('Asia/Jakarta');

class SuratMasukController extends Controller
{
    public function index()
    {

        $userModel = new User();

        $data = $userModel->getPenugasanPertama();
        // Debug::dump($data);die;

        return view('surat-masuk.index', ['users_penugasan'=>$data]);
    }

    public function detail()
    {
        return view('surat-masuk.detail');
    }

    public function addSuratMasuk(Request $request)
    {
        $datetime = date('Y-m-d H:i:s');

        // Debug::dump($request->input());die;

        if (!$_FILES){
            return response()->json(['status'=>0]);
        }

        $params = [
            'tanggal_surat' => $request->input('tanggal_surat'),
            'asal_surat' => $request->input('asal_surat'),
            'nomor_surat' => $request->input('nomor_surat'),
            'assign_to' => (int) $request->input('ditugaskan_ke'),
            'perihal_surat' => $request->input('perihal_surat'),
            'jenis_surat_masuk' => (int) $request->input('jenis_surat_masuk'),
            'id_operator' => auth()->id(),
            'created_by' => auth()->id(),
            'created_at' => $datetime,
            'updated_at' => $datetime
        ];

        // Debug::dump($params);die;

        $id = app('db')->connection()->table('surat_masuk')->insertGetId($params);
        // Debug::dump($id);die;

        $link_file = '';
        if (isset($_FILES)) {
            // Debug::dump($_FILES);die;
            $allowedfileExtensions = array('pdf');
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $fileType = $_FILES['file']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $fileName = md5($id.$fileName);
            $newFileName = "surat-masuk-{$fileName}";
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

        app('db')->connection()->update("UPDATE surat_masuk set link_file=:link_file where id=:id", ['id'=>$id, 'link_file'=>$link_file]);

        return response()->json([
            'transaction' => true
        ]);
    }

    public function getSuratMasuk(Request $request)
    {

        try {

            $SuratMasuk = new SuratMasuk();

            $data = $SuratMasuk->getAll();
            // Debug::dump($data);die;

            $result = ['data' => $data];

            return response()->json($result);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getDetailSuratMasuk(Request $request, int $id)
    {

        $params = [
            'id_surat' => $id,
            // 'assign_to' => auth()->id(),
            // 'target_disposisi' => auth()->id(),
        ];
        $sql = "SELECT
                sm.id,
                sm.tanggal_surat,
                sm.asal_surat,
                sm.perihal_surat,
                sm.nomor_surat,
                case
                    when sm.jenis_surat_masuk = 1 then 'Penting'
                    else 'Biasa'
                end as jenis_surat_masuk,
                sm.id_operator,
                sm.link_file,
                sm.assign_to,
                sm.is_disposisi,
                sm.is_proses,
                sm.is_arsip,
                sm.is_deleted,
                sm.created_by,
                u.name as created_by_name,
                u.jabatan as created_by_jabatan,
                sm.created_at
            from
                surat_masuk sm
            -- join disposisi_surat_masuk dsm on
            --     sm.id = dsm.id_surat
            left join users u on
                sm.created_by = u.id
            where
                sm.id =:id_surat
                -- and sm.is_arsip is null
                -- and (sm.assign_to = :assign_to
                --     or dsm.target_disposisi = :target_disposisi)
                ";

        // Debug::dump($params);
        // Debug::dump($sql);
        // die;
        $data = app('db')->connection()->selectOne($sql, $params);
        // Debug::dump($data);die;

        if ($data) {


            $userModel = new User();
            $SuratMasuk = new SuratMasuk();
            $data->assign_to = $userModel->getInfoById($data->assign_to);
            // Debug::dump($data);die;
    
            // $params = [
            //     'id_surat' => $id, 
            //     'from_disposisi' => auth()->id(),
            //     'to_disposisi' => auth()->id(),
            // ];
    
            // $sql = 'SELECT * FROM  disposisi_surat_masuk  WHERE id_surat=:id_surat
            // and (source_disposisi = :from_disposisi or target_disposisi=:to_disposisi)';
            // // $sql1 = 'SELECT * FROM  disposisi_surat_masuk  WHERE id_surat=:id_surat and is_selesai is null';
    
            // Debug::dump($params);
            // Debug::dump($sql);
            // die;
    
            $disposisi = $SuratMasuk->getDisposisiBySMId($id, 'ASC');
            // Debug::dump($disposisi);die;
    
            // if ($disposisi) {
            //     foreach ($disposisi as $k => $v) {
            //         $disposisi[$k]->source_disposisi = $userModel->getInfoById($v->source_disposisi);
            //         $disposisi[$k]->target_disposisi = $userModel->getInfoById($v->target_disposisi);
            //     }
            // }

            $sql = "SELECT * from proses_surat_masuk where id_surat=:id";

            $pemroses = app('db')->connection()->selectOne($sql, ['id'=>$id]);
            // Debug::dump($pemroses);die;
            if ($pemroses){
                $pemroses = $userModel->getInfoById($pemroses->created_by);
            }


        }


        $res = [
            'transaction' => ($data) ? true : false,
            'data' => $data,
            'disposisi' => $disposisi??[],
            'pemroses' => $pemroses??[]
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

        $sql = "SELECT users.id,users.name FROM  users  LEFT JOIN roles on users.role_id = roles.id where roles.level = :level";

        $data = app('db')->connection()->select($sql, ['level' => $where]);
        $res = [
            'transaction' => true,
            'data' => $data
        ];
        return response()->json($res);
    }

    public function getTrackingList(Request $request, int $id)
    {

        $SuratMasuk = new SuratMasuk();
        $surat_masuk = $SuratMasuk->getById($id);
        // Debug::dump($surat_masuk);die;

        $data = [];
        // if (
        //     ($surat_masuk->is_disposisi==null && $surat_masuk->is_proses==null) ||
        //     ($surat_masuk->is_disposisi==1 && $surat_masuk->is_proses==null)
        // ) {

            $data[] = [
                'label' => 'Surat Masuk',
                'actor' => [
                    'id' => $surat_masuk->created_by,
                    'name' => $surat_masuk->created_by_name,
                    'nip' => $surat_masuk->created_by_nip,
                    'jabatan' => $surat_masuk->created_by_jabatan,
                ],
                'datetime' => $surat_masuk->created_at
            ];

            $data[] = [
                'label' => 'Ditugaskan',
                'actor' => [
                    'id' => $surat_masuk->assign_to->id,
                    'name' => $surat_masuk->assign_to->name,
                    'nip' => $surat_masuk->assign_to->nip,
                    'jabatan' => $surat_masuk->assign_to->jabatan,
                ],
                'datetime' => $surat_masuk->created_at
            ];

            if ($surat_masuk->is_disposisi==1){
                $disposisi = $SuratMasuk->getDisposisiBySMId($surat_masuk->id, 'ASC');
                // Debug::dump($disposisi);die;
                foreach ($disposisi as $k => $v) {

                    $diposisi_ke = $k+1;
                    $data[] = [
                        'label' => "Disposisi {$diposisi_ke}",
                        'actor' => [
                            'id' => $v->target_disposisi->id,
                            'name' => $v->target_disposisi->name,
                            'nip' => $v->target_disposisi->nip,
                            'jabatan' => $v->target_disposisi->jabatan,
                        ],
                        'datetime' => $v->created_at
                    ];
                }
            }

            if ($surat_masuk->is_proses==1) {
                
                $pemroses = $SuratMasuk->getProsesBySMId($surat_masuk->id);
                // Debug::dump($pemroses);die;

                $data[] = [
                    'label' => 'Proses',
                    'actor' => [
                        'id' => $pemroses->id,
                        'name' => $pemroses->name,
                        'nip' => $pemroses->nip,
                        'jabatan' => $pemroses->jabatan,
                    ],
                    'datetime' => $pemroses->created_at
                ];

            } else {

                $data[] = [
                    'label' => 'Proses',
                    'actor' => [
                        'id' => null,
                        'name' => null,
                        'nip' => null,
                        'jabatan' => null,
                    ],
                    'datetime' => null
                ];
            }

            if ($surat_masuk->is_arsip==1) {
                
                $data[] = $data[count($data)-1];
                $data[count($data)-1]['label'] = 'Selesai';
                $data[count($data)-1]['datetime'] = $surat_masuk->updated_at;

            } else {

                $data[] = [
                    'label' => 'Selesai',
                    'actor' => [
                        'id' => null,
                        'name' => null,
                        'nip' => null,
                        'jabatan' => null,
                    ],
                    'datetime' => null
                ];

            }

        // }

        // Debug::dump($data);die;

        return response()->json(['transaction'=>true, 'data'=>$data]);

        $data_list = [];
        $sql = "SELECT sm.id, sm.is_proses,sm.is_disposisi,sm.is_arsip,sm.created_at as created_date,u.id as id_from,r.name as role_from,u.name as name_from, us.id as id_to, rs.name as role_to, us.name as name_to from  surat_masuk  sm 
        LEFT JOIN  users  u on sm.id_operator = u.id 
        LEFT JOIN  roles  r on u.role_id = r.id
        LEFT JOIN  users  us on sm.assign_to = us.id 
        LEFT JOIN  roles  rs on us.role_id = rs.id
        WHERE sm.id=:id_surat";
        $data = app('db')->connection()->selectOne($sql, ['id_surat' => $id]);

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
            $sql_cek = "SELECT psm.tanggal_proses FROM  surat_masuk  sm LEFT JOIN proses_surat_masuk psm on sm.id = psm.id_surat WHERE sm.id = :id_surat";
            $process = app('db')->connection()->selectOne($sql_cek, ['id_surat' => $id]);
            $to_process = $data->is_proses;
            $date_process = $process->tanggal_proses;
        }




        if ($data->is_disposisi != NULL) {
            $sql1 = 'select dsm.source_disposisi as id_source,us.name as name_source,rs.name as role_source,dsm.target_disposisi as id_target,ut.name as name_target,rt.name as role_target, dsm.created_at tanggal, dsm.is_selesai as proses from disposisi_surat_masuk dsm 
            left join users us on dsm.source_disposisi = us.id 
            left join users ut on dsm.target_disposisi = ut.id
            left join roles rs on us.role_id = rs.id
            left join roles rt on ut.role_id = rt.id
             where id_surat=:id_surat order by dsm.tanggal_disposisi asc';
            $dataa = app('db')->connection()->select($sql1,  ['id_surat' => $id]);
            // Debug::dump($dataa);die;

            foreach ($dataa as $k => $v) {

                $find = array_search($v->id_source, array_column($data_list, 'id'));

                if ($find == false) {
                    $data_list[$k + 1] = [
                        'status' => 'Disposisi ' . $k + 1,
                        'id' => $v->id_source,
                        'name' => $v->name_source,
                        'role' => $v->role_source,
                        'date' => $v->tanggal,
                        'proses' => 0
                    ];
                    $data_list[$k + 2] = [
                        'status' => 'Disposisi ' . $k + 2,
                        'id' => $v->id_target,
                        'name' => $v->name_target,
                        'role' => $v->role_target,
                        'date' => '',
                        'proses' => $v->proses
                    ];
                } else {
                    $data_list[$find] = [
                        'status' => 'Disposisi ' . $k + 1,
                        'id' => $v->id_source,
                        'name' => $v->name_source,
                        'role' => $v->role_source,
                        'date' => $v->tanggal,
                        'proses' => $v->proses
                    ];
                    $data_list[$find + 2] = [
                        'status' => 'Disposisi ' . $k + 2,
                        'id' => $v->id_target,
                        'name' => $v->name_target,
                        'role' => $v->role_target,
                        'date' => '',
                        'proses' => $v->proses
                    ];
                }
                // $data_list[$k + 1] = [
                //     'status' => 'Disposisi ' . $k + 1,
                //     'id' => $v->id_target,
                //     'name' => $v->name,
                //     'role' => $v->role,
                //     'date' => $v->tanggal,
                //     'proses' => $v->proses
                // ];
            }
        } else {
            $data_list[] = [
                'status' => 'Disposisi 1',
                'id' => $data->id_to,
                'name' => $data->name_to,
                'role' => $data->role_to,
                'date' => $date_process,
                'proses' => $to_process
            ];
        }

        $res = ['transaction' => true, 'data' => $data_list];
        return response()->json($res);
    }

    public function prosesSurat(Request $request, int $id)
    {

        // Debug::dump($id);Debug::dump(auth()->id());die;
        $datetime = date('Y-m-d H:i:s');

        $params = [
            'id' => $id,
            'tanggal_proses' => date('Y-m-d', strtotime($datetime)),
            'id_pemroses' => auth()->id(),
            'created_by' => auth()->id(),
            'created_at' => $datetime,
        ];

        $sql = "INSERT
                into
                proses_surat_masuk (id_surat,
                tanggal_proses,
                id_pemroses,
                created_by,
                created_at)
            values (:id,
            :tanggal_proses,
            :id_pemroses,
            :created_by,
            :created_at)";

        // Debug::dump($params);Debug::dump($sql);die;

        app('db')->connection()->insert($sql, $params);

        $params = [
            'updated_at' => $datetime,
            'id' => $id
        ];
        $sql = "UPDATE  surat_masuk  SET is_proses = 1, updated_at=:updated_at where id=:id";

        app('db')->connection()->update($sql,$params);

        return response()->json(['transaction'=>true]);

        $sql_get = "SELECT is_disposisi from surat_masuk where id=:id_surat";
        $dataa = app('db')->connection()->selectOne($sql_get,  ['id_surat' => $id_surat]);


        //INSERT TO TABLE Surat Proses
        $data_params = [
            'id_surat' => $id_surat,
            'tanggal_proses' => date("Y-m-d"),
            'id_pemroses' => $user_id,
        ];

        app('db')->connection()->insert("INSERT INTO proses_surat_masuk (id_surat,tanggal_proses,id_pemroses,created_at,updated_at) VALUES(:id_surat, :tanggal_proses, :id_pemroses, now(), now())", $data_params);


        if ($dataa->is_disposisi !== NULL) {
            $sql_update = "UPDATE disposisi_surat_masuk SET is_selesai=1, updated_at=now() WHERE id_surat=:id_surat AND target_disposisi=:user_id";
            app('db')->connection()->update(
                $sql_update,
                [
                    'id_surat' => (int)$id_surat,
                    'user_id' => (int)$user_id
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
        $datetime = date('Y-m-d H:i:s');

        $id_surat  = (int) $request->input('id_surat');
        $assign_to = (int) $request->input('assign_to');
        $user_id = (int) $request->input('user_id');

        // Debug::dump($request->input());die;

        //INSERT DISPOSISI SURAT MASUK
        $params = [
            'id_surat' => $id_surat,
            'source_disposisi' => $user_id,
            'target_disposisi' => $assign_to,
            'tanggal_disposisi' => $datetime,
            'created_by' => auth()->id(),
            'created_at' => $datetime,
            'keterangan' => $request->input('keterangan')
        ];

        $sql = "INSERT INTO disposisi_surat_masuk 
        (id_surat,source_disposisi,target_disposisi,tanggal_disposisi,created_by,created_at,keterangan) VALUES
        (:id_surat,:source_disposisi,:target_disposisi,:tanggal_disposisi,:created_by,:created_at,:keterangan)";

        // Debug::dump($params);
        // Debug::dump($sql);
        // die;

        app('db')->connection()->insert($sql, $params);

        $params = [
            'id_surat' => $id_surat,
            'updated_at' => $datetime
        ];

        //UPDATE SURAT MASUK 
        $sql = 'UPDATE surat_masuk set is_disposisi = 1, updated_at=:updated_at where id=:id_surat';
        app('db')->connection()->update($sql,$params);


        $res = [
            'transaction' => true
        ];
        return response()->json($res);
    }

    public function arsipkanSurat(Request $request, int $id){

        // Debug::dump($id);Debug::dump(auth()->id());die;
        $datetime = date('Y-m-d H:i:s');

        $sql = "UPDATE surat_masuk set is_arsip=1, updated_at=:updated_at, keterangan_arsip=:keterangan_arsip where id=:id";
        app('db')->connection()->update($sql, ['id'=>$id, 'updated_at'=>$datetime, 'keterangan_arsip'=>$request->input('keterangan')]);

        $sql = "UPDATE proses_surat_masuk set is_selesai=1, tanggal_selesai=:tanggal_selesai, updated_at=:updated_at where id_surat=:id";
        app('db')->connection()->update($sql, ['id'=>$id, 'updated_at'=>$datetime, 'tanggal_selesai'=>date('Y-m-d', strtotime($datetime))]);

        $sql = "UPDATE disposisi_surat_masuk set is_selesai=1, updated_at=:updated_at where id_surat=:id";
        app('db')->connection()->update($sql, ['id'=>$id, 'updated_at'=>$datetime]);

        return response()->json(['transaction'=>true]);
    }

    public function listArsip(Request $request){

        $params = [];
        $additional = "";
        if (!in_array(auth()->user()->role_id, [1,2])){ // [admin,operator]
            $params = [
                'user_id'=>auth()->id(),
            ];

            $additional = " and (sm.created_by=:user_id)";
        }

        $sql = "SELECT sm.id, sm.tanggal_surat, 
        case when sm.jenis_surat_masuk=0 then 'Biasa' when sm.jenis_surat_masuk=1 then 'Penting' else '-' end jenis_surat_masuk, 
        sm.perihal_surat, sm.created_by, u.\"name\" as created_by_name
        from surat_masuk sm 
        left join users u on sm.created_by=u.id
        where is_arsip = 1{$additional}";
        // Debug::dump($sql);die;

        $data = app('db')->connection()->select($sql, $params);

        // Debug::dump($data);die;

        return response()->json(['data'=>$data]);

    }
}