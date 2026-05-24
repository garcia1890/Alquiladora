<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORMULARIO RECUPERAR
    |--------------------------------------------------------------------------
    */

    public function showForgotForm()
    {
        return view('cpanel.auth.forgot-password');
    }

    /*
    |--------------------------------------------------------------------------
    | ENVIAR CORREO
    |--------------------------------------------------------------------------
    */

public function sendResetLink(Request $request)
{
    $request->validate([
        'correo' => 'required|email'
    ]);

    // Buscar usuario
    $usuario = DB::table('usuarios')
        ->where('correo', $request->correo)
        ->first();

    if (!$usuario) {
        return back()->with('error', 'El correo no existe');
    }

    /*
    |--------------------------------------------------------------------------
    | GENERAR NUEVA CONTRASEÑA
    |--------------------------------------------------------------------------
    */

   $nuevaPassword = 'GAOS-' . rand(1000,9999);

    /*
    |--------------------------------------------------------------------------
    | GUARDAR PASSWORD EN HASH
    |--------------------------------------------------------------------------
    */

    DB::table('usuarios')
        ->where('correo', $request->correo)
        ->update([
            'contrasena' => Hash::make($nuevaPassword)
        ]);

    /*
    |--------------------------------------------------------------------------
    | ENVIAR CORREO
    |--------------------------------------------------------------------------
    */

    Mail::raw(
        "Hola {$usuario->nombre},\n\n" .
        "Tu nueva contraseña temporal es:\n\n" .
        $nuevaPassword .
        "\n\nTe recomendamos cambiarla después de iniciar sesión.",
        function ($message) use ($request) {

            $message->to($request->correo)
                ->subject('Nueva contraseña - Alquiladora GAOS');
        }
    );

    return back()->with(
        'success',
        'Se envió una nueva contraseña a tu correo'
    );
}
    /*
    |--------------------------------------------------------------------------
    | FORM NUEVA CONTRASEÑA
    |--------------------------------------------------------------------------
    */

    public function showResetForm($token)
    {
        $reset = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return redirect()->route('login')
                ->with('error', 'Token inválido');
        }

        return view(
            'cpanel.auth.reset-password',
            compact('token')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR NUEVA PASSWORD
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $reset = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->with('error', 'Token inválido');
        }

        // Actualizar contraseña
        DB::table('usuarios')
            ->where('correo', $reset->correo)
            ->update([
                'contrasena' => Hash::make($request->password)
            ]);

        // Eliminar token
        DB::table('password_resets')
            ->where('correo', $reset->correo)
            ->delete();

        return redirect()->route('login')
            ->with('success', 'Contraseña actualizada');
    }
}