<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* IMPORTACION DE MODELOS*/
use App\Models\User;

/* OTRAS IMPORTACIONES */
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\{
    RegisterRequest,
    LoginRequest
};
use Exception;

class AuthController extends Controller
{
    /**
     * Method to register a users
     *
     * @param  \App\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'coins'     => 0
            ]);

            $data = User::where('id', $user->id)->first();
            $success = [
                "token" => $data->createToken('systemWhatsapp')->plainTextToken,
                "user"  => $data
            ];

            return response()->json([
                'message' => 'Usuario creado con exito',
                'data' => $success
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'auth.register.failed',
                'message' => $e->getMessage(),
            ], 505);
        }
    }

    /**
     * Method to authenticate users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        return "login";
    }
}
