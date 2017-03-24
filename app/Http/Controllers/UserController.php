<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();
        $response = ['message' => 'Successfully created user!'];
        return response()->json($response, 201);
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $response = ['error' => 'Invalid Credentials!'];
                return response()->json($response, 401);
            }
        } catch (JWTException $e) {
            $response = ['error' => 'Could not create token!'];
            return response()->json($response, 500);
        }

        $response = ['token' => $token];
        return response()->json($response, 200);
    }
}
