<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login(Request $request){
        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);

        $user = User::where("email", $fields["email"])->first();

        if(!$user || !Hash::check($fields["password"], $user->password)){
            return response()->json([
                'message' => 'Credentials are wrong!'
            ], 401);
        }

        $token = $user->createToken("token")->plainTextToken;

        return response()->json([
            'token' => $token
        ], 201);
    }
    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            'message'=> 'Logged out successfully!'
        ]);

    } 
}  
