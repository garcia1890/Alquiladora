<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EntregasController extends Controller
{
    public function index()
    {
        $entregas = DB::table('entregas')->get();
        return response()->json($entregas, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'renta_id'        => 'required|integer|exists:rentas,id',
            'fecha_entrega'   => 'required|date',
            'estado_entrega'  => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('entregas')->insertGetId([
            'renta_id'       => $request->renta_id,
            'fecha_entrega'  => $request->fecha_entrega,
            'estado_entrega' => $request->estado_entrega,
            'comentarios'    => $request->comentarios ?? null,
            'created_at'     => now(),
            'updated_at'     => now()
        ]);

        $nuevaEntrega = DB::table('entregas')->where('id', $id)->first();
        return response()->json(['message' => 'Entrega agendada', 'data' => $nuevaEntrega], 201);
    }

    public function show($id)
    {
        $entrega = DB::table('entregas')->where('id', $id)->first();
        if (!$entrega) return response()->json(['message' => 'Entrega no encontrada'], 404);
        
        return response()->json($entrega, 200);
    }

    public function update(Request $request, $id)
    {
        $entrega = DB::table('entregas')->where('id', $id)->first();
        if (!$entrega) return response()->json(['message' => 'Entrega no encontrada'], 404);

        $validator = Validator::make($request->all(), [
            'fecha_entrega'   => 'sometimes|required|date',
            'estado_entrega'  => 'sometimes|required|string|max:50',
            'comentarios'     => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('entregas')->where('id', $id)->update($datosActualizar);

        $entregaActualizada = DB::table('entregas')->where('id', $id)->first();
        return response()->json(['message' => 'Entrega actualizada', 'data' => $entregaActualizada], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('entregas')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Entrega no encontrada'], 404);

        return response()->json(['message' => 'Entrega cancelada'], 200);
    }
}