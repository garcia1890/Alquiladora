<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductoController extends Controller
{
    public function index()
    {
        $productos = DB::table('productos')->get();

        return view('cpanel.admin.index', compact('productos'));
    }

    public function edit($id)
    {
        $producto = DB::table('productos')
            ->where('id', $id)
            ->first();

        return view('cpanel.admin.editar', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        DB::table('productos')
            ->where('id', $id)
            ->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'cantidad_disponible' => $request->cantidad_disponible,
                'categoria' => $request->categoria,
                'updated_at' => now()
            ]);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        DB::table('productos')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente');
    }
    public function create()
{
    return view('cpanel.admin.agregar');
}

public function store(Request $request)
{
    DB::table('productos')->insert([

        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'cantidad_disponible' => $request->cantidad_disponible,
        'categoria' => $request->categoria,

        'created_at' => now(),
        'updated_at' => now()

    ]);

    return redirect()
        ->route('admin.productos.index')
        ->with('success', 'Producto agregado correctamente');
}
}

