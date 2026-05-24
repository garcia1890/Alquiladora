<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function loginProcess(Request $request)
    {
        $correo = $request->correo;
        $password = $request->password;

        // Buscar usuario
        $usuario = DB::table('usuarios')
            ->where('correo', $correo)
            ->first();

        // Verificar usuario
        if (!$usuario) {
            return back()->with('error', 'Usuario no encontrado');
        }

        /*
        |--------------------------------------------------------------------------
        | PASSWORD EN HASH
        |--------------------------------------------------------------------------
        */
        if (
            str_starts_with($usuario->contrasena, '$2y$') ||
            str_starts_with($usuario->contrasena, '$2a$')
        ) {

            if (Hash::check($password, $usuario->contrasena)) {

                session([
                    'usuario_id' => $usuario->id,
                    'rol_id' => $usuario->rol_id,
                    'nombre' => $usuario->nombre
                ]);

                // REDIRECCIONES POR ROL
                switch ($usuario->rol_id) {

                    case 1:
                        return redirect()->route('admin.dashboard');

                    case 2:
                        return redirect()->route('cliente.dashboard');

                    case 3:
                        return redirect()->route('empleado.dashboard');

                    default:
                        return back()->with('error', 'Rol no válido');
                }
            }

            return back()->with('error', 'Contraseña incorrecta');
        }

        /*
        |--------------------------------------------------------------------------
        | PASSWORD EN TEXTO PLANO
        |--------------------------------------------------------------------------
        */
        if ($password === $usuario->contrasena) {

            // Convertir automáticamente a HASH
            DB::table('usuarios')
                ->where('id', $usuario->id)
                ->update([
                    'contrasena' => Hash::make($password)
                ]);

            session([
                'usuario_id' => $usuario->id,
                'rol_id' => $usuario->rol_id,
                'nombre' => $usuario->nombre
            ]);

            switch ($usuario->rol_id) {

                case 1:
                    return redirect()->route('admin.dashboard');

                case 2:
                    return redirect()->route('cliente.dashboard');

                case 3:
                    return redirect()->route('empleado.dashboard');

                default:
                    return back()->with('error', 'Rol no válido');
            }
        }

        return back()->with('error', 'Contraseña incorrecta');
    }
}