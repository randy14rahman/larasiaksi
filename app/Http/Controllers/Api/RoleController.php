<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Zend\Debug\Debug;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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

        $data = app('db')->connection()->select("SELECT * from roles");
        // Debug::dump($result);die;


        $result = ['status' => 1, 'data' => $data];

        return response()->json($result);
    }

    public function addRole(Request $request)
    {


        try {
            $params = [
                'name'  => $request->input('name'),
                'level'  => (int) $request->input('level'),
            ];

            app('db')->connection()->insert("INSERT INTO roles (name, level, created_at) VALUES(:name, :level, now())", $params);
            return response()->json(['status' => 1]);
        } catch (Exception $e) {
            Debug::dump($e->getMessage());
            die;
        }
    }

    public function editRole(Request $request, $role_id)
    {
        // Debug::dump($request->input());die;

        $role_id = (int) $request->input('id');

        $params = [
            'role_id' => $role_id,
            'name'  => $request->input('name'),
            'level'  => (int) $request->input('level'),
        ];

        app('db')->connection()->insert("UPDATE roles set name=:name, level=:level where id=:role_id", $params);
        return response()->json(['status' => 1]);
    }

    public function deleteRole(Request $request, $role_id)
    {
        // Debug::dump($request->input());die;

        $role_id = (int) $role_id;

        $params = [
            'role_id' => $role_id
        ];
        // Debug::dump($params);die;

        app('db')->connection()->table('roles')->where('id', $role_id)->delete();
        return response()->json(['status' => 1]);
    }
}