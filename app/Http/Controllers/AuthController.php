<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
        // $this->request =(object)$request->all();

    }

    public function jwt(User $user)
    {
        $payload = [
            "iss" => "api-youtube-jwt",
            "sub" => $user->id,
            "iat" => time(),
            "exp" => time() + 60 * 60
        ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function authenticate(User $user)
    {      

        $this->validate(
            $this->request,
            [
                "email" => "required|email",
                "password" => "required",
                "test" => "required"
            ]
        );

        $user = User::where('email', $this->request->input('email'))->first();

        if (!$user) {
            return response()->json(
                [
                    'error' => "El correo no existe"
                ]
            );
        }

        if ($this->request->input('password') == $user->password) {

            return response()->json(
                [
                    'token' => $this->jwt($user)
                ],
                200
            );
        }

        return  response()->json(
            [
                'error' => "Credenciales incorrectas"
            ],
            400
        );
    }
}
