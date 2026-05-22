<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = DB::table('clientes')->get();
        return response()->json($clientes, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'correo'   => 'required|email|unique:clientes,correo',
            'telefono' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('clientes')->insertGetId([
            'nombre'     => $request->nombre,
            'correo'     => $request->correo,
            'telefono'   => $request->telefono ?? null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $nuevoCliente = DB::table('clientes')->where('id', $id)->first();
        return response()->json(['message' => 'Cliente creado con éxito', 'data' => $nuevoCliente], 201);
    }

    public function show($id)
    {
        $cliente = DB::table('clientes')->where('id', $id)->first();
        if (!$cliente) return response()->json(['message' => 'Cliente no encontrado'], 404);
        
        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id)
    {
        $cliente = DB::table('clientes')->where('id', $id)->first();
        if (!$cliente) return response()->json(['message' => 'Cliente no encontrado'], 404);

        $validator = Validator::make($request->all(), [
            'nombre'   => 'sometimes|required|string|max:255',
            'correo'   => 'sometimes|required|email|unique:clientes,correo,' . $id,
            'telefono' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('clientes')->where('id', $id)->update($datosActualizar);

        $clienteActualizado = DB::table('clientes')->where('id', $id)->first();
        return response()->json(['message' => 'Cliente actualizado con éxito', 'data' => $clienteActualizado], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('clientes')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Cliente no encontrado'], 404);

        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}