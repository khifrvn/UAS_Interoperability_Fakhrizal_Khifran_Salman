<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {

            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
            ]);

            $input = $request->all();

            $validationRules = [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required:confirmed',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            return response()->json($user, 200);
        }

    }

    public function login(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {

            $input = $request->all();

            $validationRules = [
                'email' => 'required|string',
                'password' => 'required|string',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            // process login
            $credentials = $request->only(['email', 'password']);

            if(! $token = Auth()->attempt($credentials)){
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            return response()->json([
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ], 200);

        }
    }
}
