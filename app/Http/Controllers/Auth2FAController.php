<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Auth2FAController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | REGISTRO
    |--------------------------------------------------------------------------
    */
    public function showRegister()
    {
        return view('cpanel.usuarios.form');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:6'
        ]);

        DB::table('usuarios')->insert([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->password),
            'rol_id' => 2,
            'created_at' => now()
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN (PASO 1)
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = DB::table('usuarios')
            ->where('correo', $request->correo)
            ->first();

        // 🔥 SOLUCIÓN PARA TEXTO PLANO Y BCRYPT
        if (
            $usuario &&
            (
                $request->password === $usuario->contrasena ||
                Hash::check($request->password, $usuario->contrasena)
            )
        ) {

            session([
                '2fa_usuario_id' => $usuario->id,
                '2fa_usuario_nombre' => $usuario->nombre,
                '2fa_correo' => $usuario->correo,
                '2fa_rol_id' => $usuario->rol_id
            ]);

            return redirect()->route('2fa.enviar');
        }

        return back()->with('error', 'Credenciales incorrectas');
    }


    /*
    |--------------------------------------------------------------------------
    | GENERAR CÓDIGO (PASO 2)
    |--------------------------------------------------------------------------
    */
    public function enviarCodigo()
    {
        $codigo = rand(100000, 999999);
        $usuario_id = session('2fa_usuario_id');
        $correo = session('2fa_correo');

        if (!$usuario_id || !$correo) {
            return redirect()->route('login')->with('error', 'Sesión inválida');
        }

        DB::table('codigos_2fa')->insert([
            'usuario_id' => $usuario_id,
            'codigo' => $codigo,
            'expiracion' => now()->addMinutes(5),
            'created_at' => now()
        ]);

        Mail::raw("Tu código de verificación es: $codigo", function ($message) use ($correo) {
            $message->to($correo)
                    ->subject('Código 2FA - Alquiladora GAOS');
        });

        return redirect()->route('2fa.form')
            ->with('success', 'Código enviado a tu correo');
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR FORMULARIO (PASO 3)
    |--------------------------------------------------------------------------
    */
    public function mostrarFormulario()
    {
        if (!session()->has('2fa_usuario_id')) {
            return redirect()->route('login');
        }

        return view('cpanel.auth.2fa');
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFICAR CÓDIGO (PASO 4)
    |--------------------------------------------------------------------------
    */
    public function verificar(Request $request)
    {
        $request->validate([
            'codigo' => 'required'
        ]);

        $usuario_id = session('2fa_usuario_id');

        if (!$usuario_id) {
            return redirect()->route('login');
        }

        $registro = DB::table('codigos_2fa')
            ->where('usuario_id', $usuario_id)
            ->where('codigo', $request->codigo)
            ->where('expiracion', '>=', now())
            ->latest()
            ->first();

        if ($registro) {

            session([
                'usuario_id' => session('2fa_usuario_id'),
                'usuario_nombre' => session('2fa_usuario_nombre'),
                'rol_id' => session('2fa_rol_id')
            ]);

            DB::table('codigos_2fa')
                ->where('usuario_id', $usuario_id)
                ->delete();

            session()->forget([
                '2fa_usuario_id',
                '2fa_usuario_nombre',
                '2fa_correo',
                '2fa_rol_id'
            ]);

            // 🔥 REDIRECCIÓN SEGÚN ROL
            if (session('rol_id') == 1) {
                return redirect()->route('admin.dashboard');
            }

            if (session('rol_id') == 3) {
                return redirect()->route('empleado.dashboard');
            }

            return redirect()->route('cliente.dashboard');
        }

        return back()->with('error', 'Código incorrecto o expirado');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }


public function reenviar2FA(Request $request)
{
    // 1. Intentamos obtener el ID del usuario desde la sesión
    // Asegúrate de que al loguear guardaste esto: session(['2fa_user_id' => $user->id]);
    $userId = session('2fa_user_id');

    if (!$userId) {
        return redirect()->route('login')
            ->withErrors(['error' => 'La sesión expiró o es inválida.']);
    }

    // 2. Generar datos del nuevo código
    $nuevoCodigo = rand(100000, 999999);
    $expiracion = now()->addMinutes(10);

    // 3. Actualizar la tabla usando el nombre exacto: 'usuarios'
    $actualizado = DB::table('usuarios')
        ->where('id', $userId)
        ->update([
            'codigo_2fa' => $nuevoCodigo,
            'codigo_2fa_expira' => $expiracion,
        ]);

    if ($actualizado) {
        // 4. Enviar notificación (Si no usas Modelos, no puedes usar $user->notify)
        // Tendrás que enviar el correo manualmente o usando el Facade Mail
        /*
        Mail::to($correoUsuario)->send(new \App\Mail\Codigo2FAMail($nuevoCodigo));
        */

        return redirect()->back()->with('success', 'Se ha enviado un nuevo código a tu correo');
    }

    return redirect()->back()->withErrors(['error' => 'No se pudo generar el código.']);
}


}