<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Alhoqbani\MobilyWs\SMS;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIRegisterController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request -> all(),[
         'phone_number' => 'required|string|max:25|unique:users',
         'name' => 'required',
         'password'=> 'required'
        ]);

        if ($validator -> fails()) {
            # code...
            return response()->json($validator->errors());
            
        }

        User::create([
            'name' => $request->get('name'),
            'phone_number' => $request->get('phone_number'),
            'password'=> bcrypt($request->get('password')),
        ]);
        \Mobily::send(966555555555, 'Your Message Here');
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        
        return Response::json( compact('token'));
        
        
    }
}
