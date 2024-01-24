<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request) {

        // Validació de les dades
        $request->validate([
            'name' => "required",
            'email' => "required|email|unique:users",
            'password' => "required|confirmed" 
        ]);
            // password_confirmation

        // Creació d'un nou usuari
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            "status" => 1,
            "msg" => "Registre de usuari amb èxit!"
        ]);
    }

    public function login(Request $request) {

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email", "=", $request->email)->first();

        if(isset($user->id)) {
           if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "status" => 1,
                    "msg" => "Usuari loguejat amb èxit!",
                    "accesss_token" => $token //Auth > Bearer > Pegar token sin comillas
                ]);
           
            } else {
            return response()->json([
                "status" => 0,
                "msg" => "Contrassenya incorrecta"
            ], 404);
           }
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "Usuari no registrat"
            ], 404);
        }
    }

    public function userProfile() {

        return response()->json([
            "status" => 0,
            "msg" => "Sobre el perfil d'usuari",
            "data" => auth()->user()
        ]);

    }

    public function logout() {

        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 1,
            "msg" => "Sessió tancada",
        ]);
    }
}
