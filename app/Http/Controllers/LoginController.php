<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Models\User as User;

/**
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * description="Ingresá el 'access_token' obtenido en el login para consumir los endpoints protegidos."
 * )
 */
class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/v1/users",
     * summary="Registrar un nuevo usuario",
     * tags={"Autenticación"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name","email","password"},
     * @OA\Property(property="name", type="string", example="Juan Pérez"),
     * @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="secret123")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Usuario creado con éxito",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="User created ok")
     * )
     * )
     * )
     */
    public function create(Request $request) {
        $credentials = $request->only('email', 'password', 'name');
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response(["message" => "User created ok"], 200);
    }

    /**
     * @OA\Post(
     * path="/api/v1/users/login",
     * summary="Iniciar sesión y obtener Bearer Token",
     * tags={"Autenticación"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"email","password"},
     * @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="secret123")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Login correcto",
     * @OA\JsonContent(
     * @OA\Property(property="user", type="object"),
     * @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiI3...")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Credenciales inválidas",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Invalid email or password")
     * )
     * )
     * )
     */
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if ( !Auth::attempt($credentials)) {
            return response(["message" => "Invalid email or password"], 401);
        }
        $accessToken = Auth::user()->createToken('authGifToken')->accessToken;
        return response([
            "user" => Auth::user(),
            "access_token" => $accessToken
        ]);
    }
}
