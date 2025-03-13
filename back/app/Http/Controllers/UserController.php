<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Exception;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            "username" => "required|max:60",
            "password" => "required|max:60",
        ]);
        //
        $user = UserModel::where("username", $validatedData["username"])->first();
        if (!$user || !Hash::check($validatedData["password"], $user->password)) 
            throw new Exception("Usuário ou senha não identificados.");
	    //
        $payload = [
            'iss' => 'movimentacao-financeira-back',
            'sub' => [
                "id" => $user->id,
                "name" => $user->name
            ],
            'iat' => time(),
            // 'exp' => time() + 3600,
        ];
        $header = [
            'kid' => $user->id,
        ];

        $token = JWT::encode(
            $payload, 
            env("JWT_SECRET", "token_jwt"), 
            "HS256", 
            $user->id, 
            $header
        );
        // 
        return response()->json([
            "token" => $token
        ]);
    }
}
