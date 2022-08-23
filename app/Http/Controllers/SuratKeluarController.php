<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Zend\Debug\Debug;

date_default_timezone_set('Asia/Jakarta');

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

    public function listSurat(Request $request)
    {

        // Debug::dump(auth()->user()->role_id);die;

        $params = [];
        $additional = "";
        if (!in_array(auth()->user()->role_id, [1, 2])) { // [admin,operator]
            $params = [
                'user_id' => auth()->id(),
                'pemaraf1' => auth()->id(),
                'pemaraf2' => auth()->id(),
                'pettd' => auth()->id(),
            ];

            $additional = " and (sk.created_by=:user_id or sk.pemaraf1=:pemaraf1 or sk.pemaraf2=:pemaraf2 or sk.pettd=:pettd)";
        }

        $sql = "SELECT sk.*, u.id as created_by_id, u.name as created_by_name from surat_keluar sk
        left join users u on sk.created_by=u.id where (is_ttd=0 or is_ttd is null) and (is_reject =0 or is_reject is null){$additional}
        order by created_at desc";

        $data = app('db')->connection()->select($sql, $params);


        $userModel = new User();
        foreach ($data as $k => $v) {


            $pemaraf1 = $userModel->getInfoById($v->pemaraf1);
            $pemaraf2 = (!is_null($v->pemaraf2) && ($v->pemaraf2) > 1) ? $userModel->getInfoById(($v->pemaraf2)) : null;
            $pettd = $userModel->getInfoById($v->pettd);

            $data[$k]->pemaraf1 = $pemaraf1;
            $data[$k]->pemaraf2 = $pemaraf2;
            $data[$k]->pettd = $pettd;
        }

        // Debug::dump($data);die;

        return response()->json(['data' => $data]);
    }

    public function listArsip(Request $request)
    {

        // Debug::dump(auth()->user()->role_id);die;

        $params = [];
        $additional = "";
        if (!in_array(auth()->user()->role_id, [1, 2])) { // [admin,operator]
            $params = [
                'user_id' => auth()->id(),
                'pemaraf1' => auth()->id(),
                'pemaraf2' => auth()->id(),
                'pettd' => auth()->id(),
            ];

            $additional = " and (sk.created_by=:user_id or sk.pemaraf1=:pemaraf1 or sk.pemaraf2=:pemaraf2 or sk.pettd=:pettd)";
        }

        $sql = "SELECT sk.*, u.id as created_by_id, u.name as created_by_name from surat_keluar sk
        left join users u on sk.created_by=u.id where (is_ttd=1 or is_reject =1) {$additional}  order by created_at desc";

        $data = app('db')->connection()->select($sql, $params);
        // Debug::dump($data);die;

        $userModel = new User();
        foreach ($data as $k => $v) {


            $pemaraf1 = $userModel->getInfoById($v->pemaraf1);
            $pemaraf2 = (!is_null($v->pemaraf2) && ($v->pemaraf2) > 1) ? $userModel->getInfoById(($v->pemaraf2)) : null;
            $pettd = $userModel->getInfoById($v->pettd);

            $data[$k]->pemaraf1 = $pemaraf1;
            $data[$k]->pemaraf2 = $pemaraf2;
            $data[$k]->pettd = $pettd;
        }

        // Debug::dump($data);die;

        return response()->json(['data' => $data]);
    }

    public function addSurat(Request $request)
    {
        // Debug::dump($request->input());die;

        if (!$_FILES) {
            return response()->json(['status' => 0]);
        }

        $params = [
            'tanggal_surat' => $request->input('tanggal_surat'),
            'perihal_surat' => $request->input('perihal'),
            'nomor_surat' => $request->input('nomor_surat'),
            'judul_surat' => $request->input('judul_surat'),
            'pettd' => (int) $request->input('pettd', 0),
            'pemaraf1' => (int) $request->input('pemaraf1'),
            'link_surat' => '',
            'created_by' => (int) $request->input('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];


        $additional_field = '';
        $additional_value = '';
        if (!is_null($request->input('pemaraf2'))) {
            $additional_field = ',pemaraf2';
            $additional_value = ',:pemaraf2';
            $params['pemaraf2'] = (int) $request->input('pemaraf2');
        }
        // Debug::dump($params);die;

        $id = app('db')->connection()->table('surat_keluar')->insertGetId($params);
        // Debug::dump($id);die;

        $link_file = '';
        $allowedfileExtensions = array('pdf');
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $fileName = md5($id . $fileName);
        $newFileName = "surat-keluar-{$fileName}";
        $dir = '/upload/surat-keluar/' . $newFileName . '.' . $fileExtension;
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

        app('db')->connection()->update("UPDATE surat_keluar set link_surat=:link_surat where id=:id", ['id' => $id, 'link_surat' => $link_file]);

        return response()->json(['status' => 1]);
    }

    public function setActiveParaf1(Request $request, $id)
    {

        $datetime = date('Y-m-d H:i:s');
        $result = app('db')->connection()->update('UPDATE surat_keluar set is_paraf1=1, paraf1_date=:paraf1_date, updated_at=:updated_at where id=:id and pemaraf1=:pemaraf1', [
            'id' => (int) $id,
            'pemaraf1' => (int) auth()->user()->id,
            'paraf1_date' => $datetime,
            'updated_at' => $datetime,
        ]);
        // Debug::dump($result);die;

        return response()->json(['status' => $result]);
    }

    public function setActiveParaf2(Request $request, $id)
    {

        $datetime = date('Y-m-d H:i:s');
        $result = app('db')->connection()->update('UPDATE surat_keluar set is_paraf2=1, paraf2_date=:paraf2_date, updated_at=:updated_at where id=:id and pemaraf2=:pemaraf2', [
            'id' => (int) $id,
            'pemaraf2' => (int) auth()->user()->id,
            'paraf2_date' => $datetime,
            'updated_at' => $datetime,
        ]);
        // Debug::dump($result);die;

        return response()->json(['status' => $result]);
    }

    public function setTtd(Request $request, $id)
    {

        $datetime = date('Y-m-d H:i:s');
        $result = app('db')->connection()->update('UPDATE surat_keluar set is_ttd=1, ttd_date=:ttd_date, updated_at=:updated_at where id=:id and pettd=:pettd', [
            'id' => (int) $id,
            'pettd' => (int) auth()->user()->id,
            'ttd_date' => $datetime,
            'updated_at' => $datetime,
        ]);
        // Debug::dump($result);die;

        return response()->json(['status' => $result]);
    }

    public function detailSurat(Request $request, int $id)
    {
        // Debug::dump($id);die;


        $params = [
            'id' => $id,
        ];
        $additional = "";
        if (!in_array(auth()->user()->role_id, [1, 2])) {
            $params2 = [
                'pemaraf1' => auth()->id(),
                'pemaraf2' => auth()->id(),
                'pettd' => auth()->id(),
            ];
            $additional = " and (sk.pemaraf1=:pemaraf1 or sk.pemaraf2=:pemaraf2 or sk.pettd=:pettd)";

            $params = array_merge($params, $params2);
        }

        $sql = "SELECT sk.id, sk.tanggal_surat, sk.perihal_surat, sk.nomor_surat, sk.judul_surat, sk.link_surat, 
        sk.pemaraf1, sk.is_paraf1, sk.paraf1_date, 
        sk.pemaraf2, sk.is_paraf2, sk.paraf2_date, 
        sk.pettd, sk.is_ttd, sk.ttd_date, 
        sk.created_at, sk.is_reject,sk.rejected,ur.name as rejected_by,sk.note_rejected,sk.reject_date,
        u.name as created_by_name 
        from surat_keluar sk 
        left join users u on sk.created_by=u.id
        left join users ur on sk.rejected = ur.id
        where sk.id=:id{$additional}";

        // Debug::dump($params);
        // Debug::dump($sql);
        // die;

        $data = app('db')->connection()->selectOne($sql, $params);

        // Debug::dump($data);
        // die;
        if ($data) {

            $userModel = new User();

            $pemaraf1 = $userModel->getInfoById($data->pemaraf1);
            $pemaraf2 = (!is_null($data->pemaraf2) && ($data->pemaraf2) > 1) ? $userModel->getInfoById($data->pemaraf2) : null;
            $pettd = $userModel->getInfoById($data->pettd);

            $data->pemaraf1 = $pemaraf1;
            $data->pemaraf2 = $pemaraf2;
            $data->pettd = $pettd;
        }

        return view('surat-keluar.detailSurat', ['data' => $data]);
    }

    public function uploadTtd(Request $request)
    {

        $id = $request->input('id');
        if (!$_FILES) {
            return response()->json(['status' => 0]);
        }

        $fileTmpPath = $_FILES['file']['tmp_name'];
        $newFileName = $_FILES['file']['full_path'];
        $dir = '/upload/surat-keluar-signed/' . $newFileName;
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

        app('db')->connection()->update("UPDATE surat_keluar set signed_surat=:signed_surat where id=:id", ['id' => $id, 'signed_surat' => $link_file]);

        return response()->json([
            'transaction' => true,
        ]);
    }

    public function rejectSurat(Request $request, int $id)
    {

        $datetime = date('Y-m-d H:i:s');

        $params = [
            "id" => $id,
            "rejected" => auth()->user()->id,
            "note_rejected" => $request->input('note'),
            "reject_date" => $datetime
        ];

        $sql = "UPDATE surat_keluar set is_reject=1,rejected=:rejected,note_rejected=:note_rejected,reject_date=:reject_date  where id=:id";
        app('db')->connection()->update($sql, $params);

        return response()->json([
            'transaction' => true,
        ]);
    }
}