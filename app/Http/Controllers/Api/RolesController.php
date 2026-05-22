<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')->get();
        return response()->json($roles, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50|unique:roles,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('roles')->insertGetId([
            'nombre'     => $request->nombre,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $nuevoRol = DB::table('roles')->where('id', $id)->first();
        return response()->json(['message' => 'Rol creado correctamente', 'data' => $nuevoRol], 201);
    }

    public function show($id)
    {
        $rol = DB::table('roles')->where('id', $id)->first();
        if (!$rol) return response()->json(['message' => 'Rol no encontrado'], 404);
        
        return response()->json($rol, 200);
    }

    public function update(Request $request, $id)
    {
        $rol = DB::table('roles')->where('id', $id)->first();
        if (!$rol) return response()->json(['message' => 'Rol no encontrado'], 404);

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:50|unique:roles,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('roles')->where('id', $id)->update($datosActualizar);

        $rolActualizado = DB::table('roles')->where('id', $id)->first();
        return response()->json(['message' => 'Rol actualizado', 'data' => $rolActualizado], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('roles')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Rol no encontrado'], 404);

        return response()->json(['message' => 'Rol eliminado'], 200);
    }
}