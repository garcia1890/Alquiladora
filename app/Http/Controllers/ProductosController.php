<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | LISTAR PRODUCTOS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $productos = DB::table('productos')->get();

        return view(
            'cpanel.productos.indexproductos',
            compact('productos')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM CREAR
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('cpanel.productos.createproductos');
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([

            'nombre' => 'required|max:100',

            'descripcion' => 'nullable',

            'precio' => 'required|numeric',

            'cantidad_disponible' => 'required|integer',

            'categoria' => 'required'

        ]);

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
            ->route('productos.index')
            ->with('success', 'Producto agregado correctamente.');
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDITAR
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $producto = DB::table('productos')
            ->where('id', $id)
            ->first();

        return view(
            'cpanel.productos.editproductos',
            compact('producto')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([

            'nombre' => 'required|max:100',

            'descripcion' => 'nullable',

            'precio' => 'required|numeric',

            'cantidad_disponible' => 'required|integer',

            'categoria' => 'required'

        ]);

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
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        DB::table('productos')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

}




