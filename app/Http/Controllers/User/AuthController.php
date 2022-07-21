<?php

namespace App\Http\Controllers\User;

use Auth;
use Validator;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => ['login', 'register']]);
    }
    public function register(Request $request)
    {
       $validator =Validator::make($request->all(),[
        'name' => 'required',
        'email' =>'required|string|email|unique:users',
        'password'=>'required|string|confirmed|min:6'

       ]);
       if($validator->fails()){
         return response()->json($validator->errors()->toJson(),400);
       }
       $user = User::create(array_merge(
           $validator->validated(),
           ['password'=>bcrypt($request->password)]
       ));
       return response()->json([
        'message'=>'User successfully registered',
        'user'=>$user
       ],201);
    }
    public function login(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'email' =>'required|email',
            'password'=>'required|string|min:6'
    
           ]);
           if($validator->fails()){
            return response()->json($validator->errors(),422);
          }
          //it makes an error if api in auth does not exist
          if(!$token = auth('api')->attempt($validator->validated())){
            return response()->json(['error'=>'Unauthenticated'],401);
         }
         return $this->createNewToken($token);

    }
    public function createNewToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth('api')->factory()->getTTL()*60,
            'user' => auth()->user()
        ]);
    }

    public function profile(){
       return response()->json(auth()->user());

    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message'=>'User logged out'
           ]);

    }
}
