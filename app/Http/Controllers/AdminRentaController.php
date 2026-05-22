<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRentaController extends Controller
{
    public function index()
    {
        $rentas = DB::table('rentas')->get();

        return view('cpanel.rentas.index', compact('rentas'));
    }

    public function create()
    {
        $clientes = DB::table('clientes')->get();

        return view('cpanel.rentas.agregar', compact('clientes'));
    }

    public function store(Request $request)
    {
        DB::table('rentas')->insert([

            'estado' => $request->estado,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'total' => $request->total,
            'cliente_id' => $request->cliente_id,

            'created_at' => now(),
            'updated_at' => now()

        ]);

        return redirect()
            ->route('admin.rentas.index')
            ->with('success', 'Renta agregada correctamente');
    }

    public function edit($id)
    {
        $renta = DB::table('rentas')
            ->where('id', $id)
            ->first();

        $clientes = DB::table('clientes')->get();

        return view('cpanel.rentas.editar', compact('renta', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        DB::table('rentas')
            ->where('id', $id)
            ->update([

                'estado' => $request->estado,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'total' => $request->total,
                'cliente_id' => $request->cliente_id,

                'updated_at' => now()

            ]);

        return redirect()
            ->route('admin.rentas.index')
            ->with('success', 'Renta actualizada correctamente');
    }

    public function destroy($id)
    {
        DB::table('rentas')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.rentas.index')
            ->with('success', 'Renta eliminada correctamente');
    }
}