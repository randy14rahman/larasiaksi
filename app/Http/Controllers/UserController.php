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
        // Debug::dump($request->input());die;

        $sql = "SELECT
            u.id,
            p.nip,
            u.name,
            u.email,
            p.id as person_id,
            p.role_id,
            r.name role_name,
            r.`level`,
            p.jabatan,
            p.is_pemaraf,
            p.is_pettd
        from
            users u
        inner join person p on
            u.id = p.user_id
        left join roles r on
            p.role_id = r.id";
        $data = app('db')->connection()->select($sql, []);
        // Debug::dump($data);die;

        $result = ['data' => $data];

        return response()->json($result);
    }

    public function addUser(Request $request) {
        // Debug::dump($request->input());die;

        $user_id = (int)$request->input('id')??0;

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $result = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $userInfo = $result->getOriginal();
        // Debug::dump($userInfo['id']);die;

        $params = [
            'user_id'   => (int) $userInfo['id'],
            'nip'       => (int) $request->input('nip'),
            'role_id'       => (int) $request->input('role'),
            'jabatan'       => $request->input('jabatan'),
            'is_pemaraf'       => (int) ($request->input('is_pemaraf')??0) == 1 ? 1: 0,
            'is_pettd'       => (int) ($request->input('is_pettd')??0) == 1 ? 1: 0,
        ];

        $result = app('db')->connection()->insert("INSERT into person (user_id, nip, role_id, jabatan, is_pemaraf, is_pettd) VALUES(:user_id, :nip, :role_id, :jabatan, :is_pemaraf, :is_pettd)", $params);

        // Debug::dump($result);die;

        return response()->json([
            'status' => 1,
            'data' => $userInfo,
        ], 200);
    
    }

    public function editUser(Request $request, $user_id){

        $user_id = (int) $user_id;
        // Debug::dump($user_id);die;
        
        $params = [
            'user_id'   => $user_id,
            'name'      => $request->input('name'),
            'email'      => $request->input('email')
        ];

        $additional_set = "";
        if ($request->input('password')!=''){
            $params['password'] = Hash::make($request->input('password'));
            $additional_set .= ", password=:password";
        }

        // Debug::dump($params);die;

        app('db')->connection()->update(
            "UPDATE users set name=:name, email=:email, updated_at=now(){$additional_set} where id=:user_id",
            $params
        );
        // Debug::dump($result);die;

        $params = [
            'user_id' => $user_id,
            'nip'       => (int) $request->input('nip'),
            'role_id'       => (int) $request->input('role'),
            'jabatan'       => $request->input('jabatan'),
            'is_pemaraf'       => (int) ($request->input('is_pemaraf')??0) == 1 ? 1: 0,
            'is_pettd'       => (int) ($request->input('is_pettd')??0) == 1 ? 1: 0,
        ];

        // Debug::dump($params);die;

        app('db')->connection()->update(
            "UPDATE person set nip=:nip, role_id=:role_id, jabatan=:jabatan, is_pemaraf=:is_pemaraf, is_pettd=:is_pettd where user_id=:user_id",
            $params
        );

        return response()->json([
            'status' => 1
        ]);
    }

    public function deleteUser(Request $request, $user_id){
        $user_id = (int) $user_id;
        // Debug::dump($user_id);die;

        app('db')->connection()->table('users')->where('id', $user_id)->delete();
        app('db')->connection()->table('person')->where('user_id', $user_id)->delete();

        return response()->json(['status'=>1]);
    }
}
