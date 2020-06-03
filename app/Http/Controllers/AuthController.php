<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
   public function register(Request $request)
   {
       $input = $request->all();
       $validator = Validator::make($input, [
           'name' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'required',
           'repeated_password' => 'required|same:password'
       ]);

       if ($validator->fails())
           return $this->sendError($validator->errors());

       $input['password'] = Hash::make($input['password']);
       $user = User::create($input);
       $success['userName'] = $user->name;
       $success['token'] = $user->createToken('authToken')->accessToken;

       return $this->sendResponse($success, 'User register successfully');
   }

   public function login(Request $request)
   {
       $input = $request->all();
       $validator = Validator::make($input, [
           'email' => 'email|required',
           'password' => 'required'
       ]);
       if ($validator->fails())
           return $this->sendError($validator->errors());
       if (!auth()->attempt($validator->validate()))
           return $this->sendError( ['main'=>['Email or Password is Invalid']], 401);

       $userName = auth()->user()->name;
       $token = auth()->user()->createToken('authToken')->accessToken;
       $data = [
           'userName' => $userName,
           'token' => $token
       ];

       return $this->sendResponse($data, 'Login successfully');

   }
}
