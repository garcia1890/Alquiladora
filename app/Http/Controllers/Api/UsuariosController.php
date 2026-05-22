<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function index()
    {
        $usuarios = DB::table('usuarios')->get();
        return response()->json($usuarios, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:usuarios,username',
            'email'    => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'rol_id'   => 'required|integer|exists:roles,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('usuarios')->insertGetId([
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'rol_id'     => $request->rol_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $nuevoUsuario = DB::table('usuarios')->where('id', $id)->first();
        return response()->json(['message' => 'Usuario creado', 'data' => $nuevoUsuario], 201);
    }

    public function show($id)
    {
        $usuario = DB::table('usuarios')->where('id', $id)->first();
        if (!$usuario) return response()->json(['message' => 'Usuario no encontrado'], 404);
        
        return response()->json($usuario, 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = DB::table('usuarios')->where('id', $id)->first();
        if (!$usuario) return response()->json(['message' => 'Usuario no encontrado'], 404);

        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|required|string|max:50|unique:usuarios,username,' . $id,
            'email'    => 'sometimes|required|email|unique:usuarios,email,' . $id,
            'password' => 'sometimes|nullable|string|min:6',
            'rol_id'   => 'sometimes|required|integer|exists:roles,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id', 'password']);
        
        // Manejo manual de la contraseña solo si la enviaron
        if ($request->filled('password')) {
            $datosActualizar['password'] = Hash::make($request->password);
        }

        $datosActualizar['updated_at'] = now();

        DB::table('usuarios')->where('id', $id)->update($datosActualizar);

        $usuarioActualizado = DB::table('usuarios')->where('id', $id)->first();
        return response()->json(['message' => 'Usuario actualizado', 'data' => $usuarioActualizado], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('usuarios')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Usuario no encontrado'], 404);

        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}