<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AutentikasiController extends Controller
{
    
    /**Register API */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $errors = $validator->errors()->toArray();
        if ($validator->fails()){
            return response()->json(array('errors'=> $errors), 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success = 'Sukses Mendaftarkan Akun';

        return response()->json(['message' => $success], 200);
    }



    /**Login API */
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

    if($validator->fails()){
        return response()->json(['error' => $validator->errors()],401);
    }
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
        $user = Auth::user();
        $success = 'Login Berhasil';
        $token = $user->createToken('nApp')->accessToken;

        return response()->json(['access_token' => $token, 'message'=> $success], 200);
    } else {
        return response()->json(['error' => 'Email atau Passowrd Salah'],401);
    }
}

/** Logout API. */

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Berhasil Logout',
        ]);
    }
}
