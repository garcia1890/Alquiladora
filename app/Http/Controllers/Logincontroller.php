<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function loginProcess(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // 🔥 BUSCAR USUARIO EN BD
        $usuario = DB::table('usuarios')
            ->where('correo', $email)
            ->first();

        // 🔥 VALIDAR USUARIO Y PASSWORD ENCRIPTADA
        if ($usuario && Hash::check($password, $usuario->password)) {

            // 👇 Usuario temporal
            $user = new GenericUser([
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'correo' => $usuario->correo,
                'rol_id' => $usuario->rol_id
            ]);

            // 🔥 LOGIN
            Auth::login($user);

            return redirect()->route('bienvenido');
        }

        return back()->withErrors([
            'login' => 'Credenciales incorrectas'
        ]);
    }

    public function bienvenido()
    {
        return view('cpanel.usuarios.bienvenido');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
