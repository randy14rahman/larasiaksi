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

    public function listSurat(Request $request) {

        // Debug::dump(auth()->user()->role_id);die;

        $params = [];
        $additional = "";
        if (!in_array(auth()->user()->role_id, [1,2])){ // [admin,operator]
            $params = [
                'user_id'=>auth()->id(),
                'pemaraf1'=>auth()->id(),
                'pemaraf2'=>auth()->id(),
                'pettd'=>auth()->id(),
            ];

            $additional = " and (sk.created_by=:user_id or sk.pemaraf1=:pemaraf1 or sk.pemaraf2=:pemaraf2 or sk.pettd=:pettd)";
        }

        $sql = "SELECT sk.*, u.id as created_by_id, u.name as created_by_name from surat_keluar sk
        left join users u on sk.created_by=u.id where (is_ttd=0 or is_ttd is null){$additional}";

        $data = app('db')->connection()->select($sql, $params);
        // Debug::dump($data);die;

        $userModel = new User();
        foreach ($data as $k => $v) {

            
            $pemaraf1 = $userModel->getInfoById($v->pemaraf1);
            $pemaraf2 = (!is_null($v->pemaraf2) && ($v->pemaraf2)>1) ? $userModel->getInfoById(($v->pemaraf2)) : null;
            $pettd = $userModel->getInfoById($v->pettd);

            $data[$k]->pemaraf1 = $pemaraf1;
            $data[$k]->pemaraf2 = $pemaraf2;
            $data[$k]->pettd = $pettd;
        }

        // Debug::dump($data);die;
        
        return response()->json(['data'=>$data]);
    }

    public function listArsip(Request $request) {

        // Debug::dump(auth()->user()->role_id);die;

        $params = [];
        $additional = "";
        if (!in_array(auth()->user()->role_id, [1,2])){ // [admin,operator]
            $params = [
                'user_id'=>auth()->id(),
                'pemaraf1'=>auth()->id(),
                'pemaraf2'=>auth()->id(),
                'pettd'=>auth()->id(),
            ];

            $additional = " and (sk.created_by=:user_id or sk.pemaraf1=:pemaraf1 or sk.pemaraf2=:pemaraf2 or sk.pettd=:pettd)";
        }

        $sql = "SELECT sk.*, u.id as created_by_id, u.name as created_by_name from surat_keluar sk
        left join users u on sk.created_by=u.id where is_ttd=1{$additional}";

        $data = app('db')->connection()->select($sql, $params);
        // Debug::dump($data);die;

        $userModel = new User();
        foreach ($data as $k => $v) {

            
            $pemaraf1 = $userModel->getInfoById($v->pemaraf1);
            $pemaraf2 = (!is_null($v->pemaraf2) && ($v->pemaraf2)>1) ? $userModel->getInfoById(($v->pemaraf2)) : null;
            $pettd = $userModel->getInfoById($v->pettd);

            $data[$k]->pemaraf1 = $pemaraf1;
            $data[$k]->pemaraf2 = $pemaraf2;
            $data[$k]->pettd = $pettd;
        }

        // Debug::dump($data);die;
        
        return response()->json(['data'=>$data]);
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
                created_by,
                created_at{$additional_field})
            VALUES (:tanggal_surat,
            :perihal_surat,
            :nomor_surat,
            :judul_surat,
            :pettd,
            :pemaraf1,
            :link_surat,
            :user_id,
            now(){$additional_value})";

        // Debug::dump($sql);
        // Debug::dump($params);die;

        app('db')->connection()->insert($sql, $params);

        return response()->json(['status'=>1]);
    }

    public function setActiveParaf1(Request $request, $id){
        $result = app('db')->connection()->update('UPDATE surat_keluar set is_paraf1=1, paraf1_date=now(), updated_at=now() where id=:id and pemaraf1=:pemaraf1', [
            'id' => (int) $id,
            'pemaraf1' => (int) auth()->user()->id
        ]);
        // Debug::dump($result);die;

        return response()->json(['status'=>$result]);
    }

    public function setActiveParaf2(Request $request, $id){
        $result = app('db')->connection()->update('UPDATE surat_keluar set is_paraf2=1, paraf2_date=now(), updated_at=now() where id=:id and pemaraf2=:pemaraf2', [
            'id' => (int) $id,
            'pemaraf2' => (int) auth()->user()->id
        ]);
        // Debug::dump($result);die;

        return response()->json(['status'=>$result]);
    }

    public function setTtd(Request $request, $id){
        $result = app('db')->connection()->update('UPDATE surat_keluar set is_ttd=1, ttd_date=now(), updated_at=now() where id=:id and pettd=:pettd', [
            'id' => (int) $id,
            'pettd' => (int) auth()->user()->id
        ]);
        // Debug::dump($result);die;

        return response()->json(['status'=>$result]);
    }
}