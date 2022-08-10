<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Zend\Debug\Debug;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $where = '';

        if (count($request->input()) > 0) {
            foreach ($request->input() as $k => $v) {
                if ($k != "_") {
                    $wh = 'u.' . $k . '=' . $v;
                    $where .= ' AND ' . $wh;
                }
            }
        }


        $sql = "SELECT
            u.id,
            u.nip,
            u.name,
            u.role_id as role,
            u.email,
            u.role_id,
            r.name role_name,
            r.`level`,
            u.jabatan,
            u.is_pemaraf,
            u.is_pettd
        from
            users u
        left join roles r on
            u.role_id = r.id WHERE 1=1" . $where;
        $data = app('db')->connection()->select($sql, []);
        // Debug::dump($data);die;

        $result = ['data' => $data];

        return response()->json($result);
    }

    public function addUser(Request $request)
    {

        // Debug::dump($request->input());

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'nip'       => (int) $request->input('nip'),
            'role_id'       => (int) $request->input('role'),
            'jabatan'       => $request->input('jabatan'),
            'is_pemaraf'       => (int) ($request->input('is_pemaraf') ?? 0) == 1 ? 1 : 0,
            'is_pettd'       => (int) ($request->input('is_pettd') ?? 0) == 1 ? 1 : 0,
            'password' => Hash::make($data['password']??'test'),
        ];

        // Debug::dump($data);die;

        app('db')->connection()->insert("INSERT INTO users (name, email, password, role_id, nip, jabatan, is_pemaraf, is_pettd) VALUES(:name, :email, :password, :role_id, :nip, :jabatan, :is_pemaraf, :is_pettd)", $data);

        return response()->json([
            'status' => 1,
            'data' => $data,
        ], 200);
    }

    public function editUser(Request $request, $user_id)
    {

        $user_id = (int) $user_id;
        // Debug::dump($user_id);die;

        // Debug::dump($request->input());

        $params = [
            'user_id'       => $user_id,
            'name'          => $request->input('name'),
            'email'         => $request->input('email'),
            'role_id'       => (int) $request->input('role'),
            'nip'           => (int) $request->input('nip'),
            'jabatan'       => $request->input('jabatan'),
            'is_pemaraf'    => (int) ($request->input('is_pemaraf') ?? 0) == 1 ? 1 : 0,
            'is_pettd'      => (int) ($request->input('is_pettd') ?? 0) == 1 ? 1 : 0,
        ];

        $additional_set = "";
        if ($request->input('password') != '') {
            $params['password'] = Hash::make($request->input('password'));
            $additional_set .= ", password=:password";
        }

        // Debug::dump($params);die;

        app('db')->connection()->update(
            "UPDATE users set name=:name, email=:email, role_id=:role_id, nip=:nip, jabatan=:jabatan, is_pemaraf=:is_pemaraf, is_pettd=:is_pettd, updated_at=now(){$additional_set} where id=:user_id",
            $params
        );
        // Debug::dump($result);die;

        return response()->json([
            'status' => 1
        ]);
    }

    public function deleteUser(Request $request, $user_id)
    {
        $user_id = (int) $user_id;
        // Debug::dump($user_id);die;

        app('db')->connection()->table('users')->where('id', $user_id)->delete();
        app('db')->connection()->table('person')->where('user_id', $user_id)->delete();

        return response()->json(['status' => 1]);
    }
}