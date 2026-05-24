<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Auth2FAController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\AdminProductoController;
use App\Http\Controllers\AdminRentaController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\LoginController;



/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// 🏠 Inicio
Route::get('/', function () {
    return view('cpanel.inicio');
})->name('home');

Route::get('/cpanel', function () {
    return view('cpanel.inicio');
})->name('cpanel');

Route::get('/cpanel/inicio', function () {
    return view('cpanel.inicio');
})->name('cpanel.inicio');


/*
|--------------------------------------------------------------------------
| REGISTRO
|--------------------------------------------------------------------------
*/

Route::get('/register', [Auth2FAController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [Auth2FAController::class, 'register'])
    ->name('register.store');


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

// 📄 Vista login
Route::get('/login', function () {
    return view('cpanel.auth.login');
})->name('login');

// 🔐 Procesar login
Route::post('/login', [Auth2FAController::class, 'login'])
    ->name('login.process');


/*
|--------------------------------------------------------------------------
| 2FA
|--------------------------------------------------------------------------
*/

// 📩 Enviar código
Route::get('/enviar-2fa', [Auth2FAController::class, 'enviarCodigo'])
    ->name('2fa.enviar');

// 📄 Formulario 2FA
Route::get('/2fa', [Auth2FAController::class, 'mostrarFormulario'])
    ->name('2fa.form');

// ✅ Verificar código
Route::post('/2fa', [Auth2FAController::class, 'verificar'])
    ->name('2fa.verificar');

// 🔄 Reenviar código
Route::post('/2fa/reenviar', [Auth2FAController::class, 'reenviar2FA'])
    ->name('2fa.reenviar');


/*
|--------------------------------------------------------------------------
| DASHBOARDS
|--------------------------------------------------------------------------
*/

// 👑 ADMIN
Route::get('/admin/dashboard', function () {

    if (!session('usuario_id') || session('rol_id') != 1) {
        return redirect()->route('login');
    }

    return view('cpanel.admin.dashboard');

})->name('admin.dashboard');


// 👷 EMPLEADO
Route::get('/empleado/dashboard', function () {

    if (!session('usuario_id') || session('rol_id') != 3) {
        return redirect()->route('login');
    }

    return view('cpanel.empleado.dashboard');

})->name('empleado.dashboard');


// 👤 CLIENTE
Route::get('/cliente/dashboard', function () {

    if (!session('usuario_id') || session('rol_id') != 2) {
        return redirect()->route('login');
    }

    return view('cpanel.cliente.dashboard');

})->name('cliente.dashboard');


/*
|--------------------------------------------------------------------------
| USUARIOS
|--------------------------------------------------------------------------
*/

// 🗑️ ELIMINAR MULTIPLES
Route::delete('/usuarios/delete-selected',
    [UsuariosController::class, 'deleteSelected']
)->name('usuarios.deleteSelected');


// 📄 FORMULARIO PUBLICO
Route::get('/cpanel/usuarios/form',
    [UsuariosController::class, 'form']
)->name('usuarios.form');


// 📋 CRUD USUARIOS
Route::resource('usuarios', UsuariosController::class);

/*
|--------------------------------------------------------------------------
| PRODUCTOS CLIENTE
|--------------------------------------------------------------------------
*/

Route::resource('productos', ProductosController::class);


/*
|--------------------------------------------------------------------------
| PRODUCTOS ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // 📋 Listar productos
    Route::get('/productos',
        [AdminProductoController::class, 'index']
    )->name('admin.productos.index');

    // ➕ Crear producto
    Route::get('/productos/agregar',
        [AdminProductoController::class, 'create']
    )->name('admin.productos.create');

    // 💾 Guardar producto
    Route::post('/productos/guardar',
        [AdminProductoController::class, 'store']
    )->name('admin.productos.store');

    // ✏️ Editar producto
    Route::get('/productos/{id}/editar',
        [AdminProductoController::class, 'edit']
    )->name('admin.productos.edit');

    // 🔄 Actualizar producto
    Route::post('/productos/{id}/actualizar',
        [AdminProductoController::class, 'update']
    )->name('admin.productos.update');

    // ❌ Eliminar producto
    Route::get('/productos/{id}/eliminar',
        [AdminProductoController::class, 'destroy']
    )->name('admin.productos.destroy');

});


/*
|--------------------------------------------------------------------------
| RENTAS ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // 📋 Listar rentas
    Route::get('/rentas',
        [AdminRentaController::class, 'index']
    )->name('admin.rentas.index');

    // ➕ Crear renta
    Route::get('/rentas/agregar',
        [AdminRentaController::class, 'create']
    )->name('admin.rentas.create');

    // 💾 Guardar renta
    Route::post('/rentas/guardar',
        [AdminRentaController::class, 'store']
    )->name('admin.rentas.store');

    // ✏️ Editar renta
    Route::get('/rentas/{id}/editar',
        [AdminRentaController::class, 'edit']
    )->name('admin.rentas.edit');

    // 🔄 Actualizar renta
    Route::post('/rentas/{id}/actualizar',
        [AdminRentaController::class, 'update']
    )->name('admin.rentas.update');

    // ❌ Eliminar renta
    Route::get('/rentas/{id}/eliminar',
        [AdminRentaController::class, 'destroy']
    )->name('admin.rentas.destroy');

});


/*
|--------------------------------------------------------------------------
| REPORTES
|--------------------------------------------------------------------------
*/

Route::prefix('admon')->group(function () {

    Route::get('/reportes/pdf',
        [ReportesController::class, 'usuariosPDF']
    )->name('reporte.usuarios');

});


/*
|--------------------------------------------------------------------------
| GRÁFICAS ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/admin/graficas', function () {

    if (!session('usuario_id') || session('rol_id') != 1) {
        return redirect()->route('login');
    }

    $admins = DB::table('usuarios')
        ->where('rol_id', 1)
        ->count();

    $clientes = DB::table('usuarios')
        ->where('rol_id', 2)
        ->count();

    $empleados = DB::table('usuarios')
        ->where('rol_id', 3)
        ->count();

    return view('cpanel.admin.graficas', compact(
        'admins',
        'clientes',
        'empleados'
    ));

})->name('admin.graficas');


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout',
    [Auth2FAController::class, 'logout']
)->name('logout');


/*
|--------------------------------------------------------------------------
| LIMPIAR SESIÓN
|--------------------------------------------------------------------------
*/

Route::get('/limpiar', function () {

    session()->flush();

    return 'Sesión eliminada';

});


/*
|--------------------------------------------------------------------------
| PRUEBA LAYOUT
|--------------------------------------------------------------------------
*/

Route::get('/app', function () {
    return view('cpanel.layouts.app');
});

Route::post('/registro', [UsuariosController::class, 'registro'])
    ->name('usuarios.registro');


    /*
|--------------------------------------------------------------------------
| CLIENTE
|--------------------------------------------------------------------------
*/

Route::get('/cliente/perfil', function () {

    return view('cpanel.cliente.perfil');

})->name('cliente.perfil');


Route::get('/cliente/carrito', function () {

    return view('cpanel.cliente.carrito');

})->name('cliente.carrito');


Route::get('/cliente/rentas', function () {

    return view('cpanel.cliente.rentas');

})->name('cliente.rentas');


Route::get('/perfil', [ClientesController::class, 'perfil'])
    ->name('cliente.perfil');

Route::post('/perfil/actualizar', [ClientesController::class, 'actualizarPerfil'])
    ->name('cliente.actualizarPerfil');

    /*
|--------------------------------------------------------------------------
| RECUPERAR CONTRASEÑA
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password',
    [PasswordResetController::class, 'showForgotForm']
)->name('password.request');

Route::post('/forgot-password',
    [PasswordResetController::class, 'sendResetLink']
)->name('password.email');



Route::post('/reset-password',
    [PasswordResetController::class, 'resetPassword']
)->name('password.update');

//CLIENTE - AGREGAR AL CARRITO
Route::post('/cliente/agregar-carrito',
    [ClientesController::class, 'agregarCarrito'])
    ->name('cliente.agregar.carrito');

    Route::get('/cliente/dashboard',
    [ClientesController::class, 'dashboard'])
    ->name('cliente.dashboard');


    Route::post('/cliente/agregar-carrito',
    [ClientesController::class, 'agregarCarrito'])
    ->name('cliente.agregar.carrito');

    Route::get('/cliente/carrito',
    [ClientesController::class, 'carrito'])
    ->name('cliente.carrito');

    Route::post('/cliente/confirmar-renta',
    [ClientesController::class, 'confirmarRenta'])
    ->name('cliente.confirmar.renta');

    Route::get('/cliente/rentas',
    [ClientesController::class, 'rentas'])
    ->name('cliente.rentas');

    Route::get('/cliente/confirmar-renta',
    [ClientesController::class, 'confirmarRentaView'])
    ->name('cliente.confirmar.renta.view');

Route::post('/cliente/guardar-renta',
    [ClientesController::class, 'confirmarRenta'])
    ->name('cliente.guardar.renta');
