<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        // $validator = $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ]);

        // $rules = [
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ];

        // $messages =[
        //     'email.required' => 'Necesitas colocar un email valido',
        //     'password.required' => 'Se necesita que ingreses una contraseña'
        // ];


        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => $validator->customMessages,
        //     ], 401);
        // }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required'
        ]);
        // if ($validator->fails()) {
        //     // return response()->json($validator->errors());
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => $validator->errors(),
        //     ], 401);
        // }

        if ($validator->fails()) {
            // return response()->json($validator->errors());
            return response()->json([
                'status' => 'error',
                'message' => 'El correo electrónico o la clave son obligatorios',
            ], 401);
        }


        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'El correo electrónico o la clave son incorrectos',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'mensaje' => 'Te has logueado con éxito',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'Usuario creado con éxito',
            'user' => $user,
            // 'authorisation' => [
            //     'token' => $token,
            //     'type' => 'bearer',
            // ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Se cerro sesión con éxito',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
