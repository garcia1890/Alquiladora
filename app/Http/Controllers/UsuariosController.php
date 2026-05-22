<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Codigo2FAMail;

class UsuariosController extends Controller
{
    // 📋 LISTAR USUARIOS
    public function index()
    {
        $usuarios = DB::table('usuarios')
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'cpanel.usuarios.indexusuarios',
            compact('usuarios')
        );
    }

    // ➕ VISTA CREAR USUARIO ADMIN
    public function create()
    {
        return view('cpanel.usuarios.createusuarios');
    }

    // 💾 GUARDAR USUARIO DESDE ADMIN
    public function store(Request $request)
    {
        $request->validate([

            'nombre' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'apellido_pa' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'apellido_ma' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'correo' => [
                'required',
                'email',
                'unique:usuarios,correo'
            ],

            'telefono' => [
                'required',
                'digits:10'
            ],

            'contrasena' => [
                'required',
                'min:8',
                'max:50'
            ],

            'rol_id' => [
                'required'
            ]
        ]);

        DB::table('usuarios')->insert([

            'nombre' => $request->nombre,

            'apellido_pa' => $request->apellido_pa,

            'apellido_ma' => $request->apellido_ma,

            'correo' => $request->correo,

            'telefono' => $request->telefono,

            'contrasena' => bcrypt($request->contrasena),

            'rol_id' => $request->rol_id,

            'created_at' => now(),

            'updated_at' => now()
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario creado correctamente.'
            );
    }

    // 📝 REGISTRO PUBLICO
    public function registro(Request $request)
    {
        $request->validate([

            'nombre' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'apellido_pa' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'apellido_ma' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'correo' => [
                'required',
                'email',
                'unique:usuarios,correo'
            ],

            'telefono' => [
                'required',
                'digits:10'
            ],

            'contrasena' => [
                'required',
                'min:8',
                'max:50'
            ]
        ]);

        DB::table('usuarios')->insert([

            'nombre' => $request->nombre,

            'apellido_pa' => $request->apellido_pa,

            'apellido_ma' => $request->apellido_ma,

            'correo' => $request->correo,

            'telefono' => $request->telefono,

            'contrasena' => bcrypt($request->contrasena),

            'rol_id' => 2,

            'created_at' => now(),

            'updated_at' => now()
        ]);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Usuario registrado correctamente.'
            );
    }

    // 🔐 LOGIN
    public function login(Request $request)
    {
        $request->validate([

            'correo' => [
                'required',
                'email'
            ],

            'contrasena' => [
                'required'
            ]
        ]);

        $user = DB::table('usuarios')
            ->where('correo', $request->correo)
            ->first();

        // ❌ Usuario no existe
        if (!$user) {

            return back()
                ->withErrors([
                    'correo' => 'Correo no encontrado.'
                ]);
        }

        // ❌ Contraseña incorrecta
        if (
            !password_verify(
                $request->contrasena,
                $user->contrasena
            )
        ) {

            return back()
                ->withErrors([
                    'contrasena' => 'Contraseña incorrecta.'
                ]);
        }

        // ✅ SESION
        session([

            'user_id' => $user->id,

            'user_email' => $user->correo
        ]);

        // 🔢 CODIGO 2FA
        $codigo = rand(100000, 999999);

        DB::table('usuarios')
            ->where('id', $user->id)
            ->update([

                'codigo_2fa' => $codigo,

                'codigo_2fa_expira' => now()->addMinutes(5),

                'updated_at' => now()
            ]);

        // 📧 ENVIAR CORREO
        Mail::to($user->correo)
            ->send(new Codigo2FAMail($codigo));

        return redirect()
            ->route('2fa.form');
    }

    // ✏️ EDITAR
    public function edit($id)
    {
        $usuario = DB::table('usuarios')
            ->where('id', $id)
            ->first();

        if (!$usuario) {

            return redirect()
                ->route('usuarios.index')
                ->with(
                    'error',
                    'Usuario no encontrado.'
                );
        }

        return view(
            'cpanel.usuarios.editusuarios',
            compact('usuario')
        );
    }

    // 🔄 ACTUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([

            'nombre' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'apellido_pa' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'apellido_ma' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:50'
            ],

            'correo' => [
                'required',
                'email',
                'unique:usuarios,correo,' . $id . ',id'
            ],

            'telefono' => [
                'required',
                'digits:10'
            ]
        ]);

        $data = [

            'nombre' => $request->nombre,

            'apellido_pa' => $request->apellido_pa,

            'apellido_ma' => $request->apellido_ma,

            'correo' => $request->correo,

            'telefono' => $request->telefono,

            'rol_id' => $request->rol_id ?? 2,

            'updated_at' => now()
        ];

        // 🔐 CONTRASEÑA OPCIONAL
        if ($request->filled('contrasena')) {

            $data['contrasena'] =
                bcrypt($request->contrasena);
        }

        DB::table('usuarios')
            ->where('id', $id)
            ->update($data);

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario actualizado correctamente.'
            );
    }

    // ❌ ELIMINAR
    public function destroy($id)
    {
        DB::table('usuarios')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario eliminado correctamente.'
            );
    }

    // 🗑️ ELIMINAR MULTIPLES
    public function deleteSelected(Request $request)
    {
        $request->validate([

            'ids' => [
                'required',
                'array'
            ]
        ]);

        DB::table('usuarios')
            ->whereIn('id', $request->ids)
            ->delete();

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuarios eliminados correctamente.'
            );
    }

    // 📄 FORM PUBLICO
    public function form()
    {
        return view('cpanel.usuarios.form');
    }
}