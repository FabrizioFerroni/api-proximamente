<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsuarioResource;
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

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
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
                'token' => $this->respondWithToken($token),
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
        // return response()->json([
        //     'status' => 'success',
        //     'token' => Auth::refresh(),
        //     'type' => 'bearer',
        // ]);
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer ',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }


    public function count()
    {
        return response()->json([
            "total" => count(User::get()),
        ], 200);
    }


    public function getUsers()
    {
        $user = UsuarioResource::collection(User::orderBy('id', 'DESC')->get());
        return response()->json([
            "usuarios" => $user,
        ], 200);
    }

    public function getMyuser(){
        $user = Auth::user();
        return response()->json([
            "usuario" => $user,
        ], 200);
    }
}
