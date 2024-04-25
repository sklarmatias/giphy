<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Models\User as User;

class LoginController extends Controller
{
    public function create(Request $request) {
        $credentials = $request->only('email', 'password', 'name');
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response(["message" => "User created ok"], 200);
    }

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
