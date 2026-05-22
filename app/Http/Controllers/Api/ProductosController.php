<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    public function index()
    {
        $productos = DB::table('productos')->get();
        return response()->json($productos, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_renta'=> 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = DB::table('productos')->insertGetId([
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion ?? null,
            'precio_renta' => $request->precio_renta,
            'stock'        => $request->stock,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        $nuevoProducto = DB::table('productos')->where('id', $id)->first();
        return response()->json(['message' => 'Producto creado', 'data' => $nuevoProducto], 201);
    }

    public function show($id)
    {
        $producto = DB::table('productos')->where('id', $id)->first();
        if (!$producto) return response()->json(['message' => 'Producto no encontrado'], 404);
        
        return response()->json($producto, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = DB::table('productos')->where('id', $id)->first();
        if (!$producto) return response()->json(['message' => 'Producto no encontrado'], 404);

        $validator = Validator::make($request->all(), [
            'nombre'       => 'sometimes|required|string|max:255',
            'precio_renta' => 'sometimes|required|numeric|min:0',
            'stock'        => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datosActualizar = $request->except(['id']);
        $datosActualizar['updated_at'] = now();

        DB::table('productos')->where('id', $id)->update($datosActualizar);

        $productoActualizado = DB::table('productos')->where('id', $id)->first();
        return response()->json(['message' => 'Producto actualizado', 'data' => $productoActualizado], 200);
    }

    public function destroy($id)
    {
        $affected = DB::table('productos')->where('id', $id)->delete();
        if (!$affected) return response()->json(['message' => 'Producto no encontrado'], 404);

        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}