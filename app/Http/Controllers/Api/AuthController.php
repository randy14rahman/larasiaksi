<?php

namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Zend\Debug\Debug;

class AuthController extends BaseController
{

    public function login(Request $request){

        // Debug::dump(Auth::attempt(['email' => $request->username, 'password' => $request->password]));die;
        if(Auth::attempt(['email' => $request->username, 'password' => $request->password])){ 
            // die('ok');
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
