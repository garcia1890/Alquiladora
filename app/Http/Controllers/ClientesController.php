<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{

    // PERFIL
    public function perfil()
    {

        // VALIDAR SESION
        if (!session()->has('usuario_id')) {

            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesión');

        }

        // BUSCAR USUARIO
        $usuario = DB::table('usuarios')
            ->where('id', session('usuario_id'))
            ->first();

        // VALIDAR USUARIO
        if (!$usuario) {

            return redirect()
                ->route('login')
                ->with('error', 'Usuario no encontrado');

        }

        return view('cpanel.cliente.perfil', compact('usuario'));

    }


    // ACTUALIZAR PERFIL
// ACTUALIZAR PERFIL
public function actualizarPerfil(Request $request)
{

// VALIDAR SESION
if (!session()->has('usuario_id')) {

    return redirect()
        ->route('login');

}

$usuarioId = session('usuario_id');

// VALIDACIONES
$request->validate([

    'correo' => [
        'required',
        'email',
        'unique:usuarios,correo,' . $usuarioId . ',id'
    ],

    'telefono' => [
        'required',
        'digits:10'
    ],

    'calle' => [
        'nullable',
        'max:100'
    ],

    'numero' => [
        'nullable',
        'max:20'
    ],

    'codigo_postal' => [
        'nullable',
        'max:10'
    ],

    'municipio' => [
        'nullable',
        'max:100'
    ],

    'estado' => [
        'nullable',
        'max:100'
    ],

    'contrasena' => [
        'nullable',
        'min:8',
        'confirmed'
    ]

]);

// DATOS A ACTUALIZAR
$data = [

    'correo' => $request->correo,

    'telefono' => $request->telefono,

    'calle' => $request->calle,

    'numero' => $request->numero,

    'codigo_postal' => $request->codigo_postal,

    'municipio' => $request->municipio,

    'estado' => $request->estado,

    'updated_at' => now()

];

// ACTUALIZAR CONTRASEÑA SI EXISTE
if ($request->filled('contrasena')) {

    $data['contrasena'] =
        bcrypt($request->contrasena);

}

// ACTUALIZAR USUARIO
DB::table('usuarios')
    ->where('id', $usuarioId)
    ->update($data);

return redirect()
    ->route('cliente.perfil')
    ->with(
        'success',
        'Perfil actualizado correctamente'
    );
}
public function dashboard()
{
    $productos = DB::table('productos')
        ->where('stock_disponible', '>', 0)
        ->get();

    return view('cpanel.cliente.dashboard', compact('productos'));
}

public function confirmarRenta()
{
    $carrito = DB::table('carrito')

        ->join(
            'productos',
            'carrito.producto_id',
            '=',
            'productos.id'
        )

        ->where(
            'carrito.usuario_id',
            session('usuario_id')
        )

        ->select(
            'carrito.*',
            'productos.precio',
            'productos.stock_disponible'
        )

        ->get();

    if($carrito->isEmpty())
    {
        return back()->with('error', 'Carrito vacío');
    }

    $total = 0;

    foreach($carrito as $item)
    {
        $total += $item->precio * $item->cantidad;
    }

    $rentaId = DB::table('rentas')->insertGetId([

        'estado' => 'Pendiente',

        'fecha_inicio' => now(),

        'fecha_fin' => now()->addDays(3),

        'total' => $total,

        'cliente_id' => session('usuario_id'),

        'created_at' => now(),

        'updated_at' => now()
    ]);

    foreach($carrito as $item)
    {
        $subtotal = $item->precio * $item->cantidad;

        DB::table('detalle_rentas')->insert([

            'cantidad' => $item->cantidad,

            'precio_unitario' => $item->precio,

            'subtotal' => $subtotal,

            'renta_id' => $rentaId,

            'producto_id' => $item->producto_id,

            'created_at' => now(),

            'updated_at' => now()
        ]);

        DB::table('productos')
            ->where('id', $item->producto_id)
            ->decrement(
                'stock_disponible',
                $item->cantidad
            );
    }

    DB::table('carrito')
        ->where(
            'usuario_id',
            session('usuario_id')
        )
        ->delete();

    return redirect()
        ->route('cliente.rentas')
        ->with('success', 'Renta realizada');
}

public function agregarCarrito(Request $request)
{
    $producto = DB::table('productos')
        ->where('id', $request->producto_id)
        ->first();

    if(!$producto)
    {
        return back()->with('error', 'Producto no encontrado');
    }

    if($request->cantidad > $producto->stock_disponible)
    {
        return back()->with('error', 'Stock insuficiente');
    }

    $existe = DB::table('carrito')

        ->where('usuario_id', session('usuario_id'))

        ->where('producto_id', $request->producto_id)

        ->first();

    if($existe)
    {
        DB::table('carrito')

            ->where('id', $existe->id)

            ->update([

                'cantidad' =>
                    $existe->cantidad + $request->cantidad,

                'updated_at' => now()
            ]);
    }
    else
    {
        DB::table('carrito')->insert([

            'usuario_id' => session('usuario_id'),

            'producto_id' => $request->producto_id,

            'cantidad' => $request->cantidad,

            'created_at' => now(),

            'updated_at' => now()
        ]);
    }

    return back()->with('success', 'Producto agregado al carrito');
}
public function carrito()
{
    $carrito = DB::table('carrito')

        ->join(
            'productos',
            'carrito.producto_id',
            '=',
            'productos.id'
        )

        ->where(
            'carrito.usuario_id',
            session('usuario_id')
        )

        ->select(

            'carrito.id',

            'productos.nombre',

            'productos.precio',

            'carrito.cantidad',

            DB::raw(
                'productos.precio * carrito.cantidad as subtotal'
            )
        )

        ->get();

    $total = $carrito->sum('subtotal');

    return view(
        'cpanel.cliente.carrito',
        compact('carrito', 'total')
    );
}
public function rentas()
{
    $rentas = DB::table('rentas')

        ->where(
            'cliente_id',
            session('usuario_id')
        )

        ->orderBy('id', 'desc')

        ->get();

    foreach($rentas as $renta)
    {
        $renta->detalles = DB::table('detalle_rentas')

            ->join(
                'productos',
                'detalle_rentas.producto_id',
                '=',
                'productos.id'
            )

            ->where(
                'detalle_rentas.renta_id',
                $renta->id
            )

            ->select(
                'productos.nombre',
                'detalle_rentas.cantidad',
                'detalle_rentas.precio_unitario',
                'detalle_rentas.subtotal'
            )

            ->get();
    }

    return view(
        'cpanel.cliente.rentas',
        compact('rentas')
    );
}
public function devolverRenta($id)
{
    $detalles = DB::table('detalle_rentas')
        ->where('renta_id', $id)
        ->get();

    foreach($detalles as $detalle)
    {
        DB::table('productos')

            ->where('id', $detalle->producto_id)

            ->increment(
                'stock_disponible',
                $detalle->cantidad
            );
    }

    DB::table('rentas')

        ->where('id', $id)

        ->update([

            'estado' => 'Completada',

            'updated_at' => now()
        ]);

    return back()->with(
        'success',
        'Renta devuelta correctamente'
    );
}


public function confirmarRentaView()
{
    $carrito = DB::table('carrito')

        ->join(
            'productos',
            'carrito.producto_id',
            '=',
            'productos.id'
        )

        ->where(
            'carrito.usuario_id',
            session('usuario_id')
        )

        ->select(
            'productos.id as producto_id',
            'productos.nombre',
            'productos.precio',
            'carrito.cantidad',

            DB::raw(
                'productos.precio * carrito.cantidad as subtotal'
            )
        )

        ->get();

    $total = $carrito->sum('subtotal');

    return view(
        'cpanel.cliente.confirmar-renta',
        compact('carrito', 'total')
    );
}
}