<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PagosController extends Controller
{
    public function index()
    {
        $pagos = DB::table('pagos')->get();
        return response()->json($pagos, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'renta_id'     => 'required|integer|exists:rentas,id',
            'monto'        => 'required|numeric|min:0.01',
            'metodo_pago'  => 'required|string|max:50',
            'fecha_pago'   => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('pagos')->insertGetId([
            'renta_id'    => $request->renta_id,
            'monto'       => $request->monto,
            'metodo_pago' => $request->metodo_pago,
            'fecha_pago'  => $request->fecha_pago,
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

        $nuevoPago = DB::table('pagos')->where('id', $id)->first();
        return response()->json(['message' => 'Pago registrado con éxito', 'data' => $nuevoPago], 201);
    }

    public function show($id)
    {
        $pago = DB::table('pagos')->where('id', $id)->first();
        if (!$pago) return response()->json(['message' => 'Pago no encontrado'], 404);
        
        return response()->json($pago, 200);
    }

    public function update(Request $request, $id)
    {
        $pago = DB::table('pagos')->where('id', $id)->first();
        if (!$pago) return response()->json(['message' => 'Pago no encontrado'], 404);

        $validator = Validator::make($request->all(), [
            'monto'       => 'sometimes|required|numeric|min:0.01',
            'metodo_pago' => 'sometimes|required|string|max:50',
            'estado'      => 'sometimes|required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('pagos')->where('id', $id)->update($datosActualizar);

        $pagoActualizado = DB::table('pagos')->where('id', $id)->first();
        return response()->json(['message' => 'Pago actualizado', 'data' => $pagoActualizado], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('pagos')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Pago no encontrado'], 404);

        return response()->json(['message' => 'Pago eliminado'], 200);
    }
}