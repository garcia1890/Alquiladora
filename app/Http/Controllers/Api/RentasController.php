<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RentasController extends Controller
{
    public function index()
    {
        $rentas = DB::table('rentas')->get();
        return response()->json($rentas, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id'   => 'required|integer|exists:clientes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'total'        => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('rentas')->insertGetId([
            'cliente_id'   => $request->cliente_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'total'        => $request->total,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        $nuevaRenta = DB::table('rentas')->where('id', $id)->first();
        return response()->json(['message' => 'Renta registrada con éxito', 'data' => $nuevaRenta], 201);
    }

    public function show($id)
    {
        $renta = DB::table('rentas')->where('id', $id)->first();
        if (!$renta) return response()->json(['message' => 'Renta no encontrada'], 404);
        
        return response()->json($renta, 200);
    }

    public function update(Request $request, $id)
    {
        $renta = DB::table('rentas')->where('id', $id)->first();
        if (!$renta) return response()->json(['message' => 'Renta no encontrada'], 404);

        $validator = Validator::make($request->all(), [
            'fecha_fin' => 'sometimes|required|date|after_or_equal:fecha_inicio',
            'estado'    => 'sometimes|required|string',
            'total'     => 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('rentas')->where('id', $id)->update($datosActualizar);

        $rentaActualizada = DB::table('rentas')->where('id', $id)->first();
        return response()->json(['message' => 'Renta actualizada', 'data' => $rentaActualizada], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('rentas')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Renta no encontrada'], 404);

        return response()->json(['message' => 'Renta eliminada'], 200);
    }
}