<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetalleRentasController extends Controller
{
    public function index()
    {
        $detalles = DB::table('detalle_rentas')->get();
        return response()->json($detalles, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'renta_id'    => 'required|integer|exists:rentas,id',
            'producto_id' => 'required|integer|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('detalle_rentas')->insertGetId([
            'renta_id'    => $request->renta_id,
            'producto_id' => $request->producto_id,
            'cantidad'    => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        $nuevoDetalle = DB::table('detalle_rentas')->where('id', $id)->first();
        return response()->json(['message' => 'Detalle de renta añadido', 'data' => $nuevoDetalle], 201);
    }

    public function show($id)
    {
        $detalle = DB::table('detalle_rentas')->where('id', $id)->first();
        if (!$detalle) return response()->json(['message' => 'Detalle no encontrado'], 404);
        
        return response()->json($detalle, 200);
    }

    public function update(Request $request, $id)
    {
        $detalle = DB::table('detalle_rentas')->where('id', $id)->first();
        if (!$detalle) return response()->json(['message' => 'Detalle no encontrado'], 404);

        $validator = Validator::make($request->all(), [
            'cantidad' => 'sometimes|required|integer|min:1',
            'precio_unitario' => 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('detalle_rentas')->where('id', $id)->update($datosActualizar);

        $detalleActualizado = DB::table('detalle_rentas')->where('id', $id)->first();
        return response()->json(['message' => 'Detalle actualizado', 'data' => $detalleActualizado], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('detalle_rentas')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Detalle no encontrado'], 404);

        return response()->json(['message' => 'Detalle eliminado'], 200);
    }
}