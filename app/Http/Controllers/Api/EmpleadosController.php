<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmpleadosController extends Controller
{
    public function index()
    {
        $empleados = DB::table('empleados')->get();
        return response()->json($empleados, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'puesto' => 'required|string|max:100',
            'salario'=> 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('empleados')->insertGetId([
            'nombre'  => $request->nombre,
            'puesto'  => $request->puesto,
            'salario' => $request->salario,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $nuevoEmpleado = DB::table('empleados')->where('id', $id)->first();
        return response()->json(['message' => 'Empleado registrado', 'data' => $nuevoEmpleado], 201);
    }

    public function show($id)
    {
        $empleado = DB::table('empleados')->where('id', $id)->first();
        if (!$empleado) return response()->json(['message' => 'Empleado no encontrado'], 404);
        
        return response()->json($empleado, 200);
    }

    public function update(Request $request, $id)
    {
        $empleado = DB::table('empleados')->where('id', $id)->first();
        if (!$empleado) return response()->json(['message' => 'Empleado no encontrado'], 404);

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'puesto' => 'sometimes|required|string|max:100',
            'salario'=> 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('empleados')->where('id', $id)->update($datosActualizar);

        $empleadoActualizado = DB::table('empleados')->where('id', $id)->first();
        return response()->json(['message' => 'Empleado actualizado', 'data' => $empleadoActualizado], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('empleados')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Empleado no encontrado'], 404);

        return response()->json(['message' => 'Empleado dado de baja'], 200);
    }
}