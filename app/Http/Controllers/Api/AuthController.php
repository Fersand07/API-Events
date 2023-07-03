<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use AWS\CRT\HTTP\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $user = new User();
        $user->password = Hash::make($request->password);

    }
 

   public function login(Request $request){
      $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required']
      ]);

      if (Auth::attempt($credentials)){
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        return response(["token"=>$token]);
      }else{
         return response("Message"); 
      }
   }

   public function userProfile(Request $request){
    return response()->json([
        "message" => "User Profile OK",
        "userData" => auth()->user()
    ]);
}

    public function logout(Request $request){
    

}

    public function allUsers(Request $request){
    
}
}
