<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Codigos2FAController extends Controller
{
    public function index()
    {
        $codigos = DB::table('codigos_2fa')->get();
        return response()->json($codigos, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario_id' => 'required|integer|exists:usuarios,id',
            'codigo'     => 'required|string|size:6',
            'expires_at' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('codigos_2fa')->insertGetId([
            'usuario_id' => $request->usuario_id,
            'codigo'     => $request->codigo,
            'expires_at' => $request->expires_at,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $nuevoCodigo = DB::table('codigos_2fa')->where('id', $id)->first();
        return response()->json(['message' => 'Código 2FA generado', 'data' => $nuevoCodigo], 201);
    }

    public function show($id)
    {
        $codigo = DB::table('codigos_2fa')->where('id', $id)->first();
        if (!$codigo) return response()->json(['message' => 'Registro no encontrado'], 404);
        
        return response()->json($codigo, 200);
    }

    public function update(Request $request, $id)
    {
        $codigo = DB::table('codigos_2fa')->where('id', $id)->first();
        if (!$codigo) return response()->json(['message' => 'Registro no encontrado'], 404);

        $validator = Validator::make($request->all(), [
            'codigo'     => 'sometimes|required|string|size:6',
            'expires_at' => 'sometimes|required|date',
            'usado'      => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('codigos_2fa')->where('id', $id)->update($datosActualizar);
        
        $codigoActualizado = DB::table('codigos_2fa')->where('id', $id)->first();
        return response()->json(['message' => 'Registro actualizado', 'data' => $codigoActualizado], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('codigos_2fa')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Registro no encontrado'], 404);

        return response()->json(['message' => 'Registro eliminado'], 200);
    }
}