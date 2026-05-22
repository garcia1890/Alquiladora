@extends('cpanel.app')

@section('title', 'Inventario Administrador')

@section('content')

<style>

    .inventario-container{
        max-width: 1400px;
        margin: auto;
    }

    .inventario-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .inventario-title{
        font-size: 34px;
        font-weight: bold;
        color: #222;
    }

    .inventario-subtitle{
        color: #666;
        margin-top: 5px;
    }

    .btn-agregar{
        background: #111;
        color: white;
        padding: 14px 22px;
        border-radius: 12px;
        text-decoration: none;
        transition: .3s;
        font-weight: 600;
    }

    .btn-agregar:hover{
        background: #333;
        transform: translateY(-2px);
    }

    .table-container{
        background: white;
        border-radius: 25px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
        overflow-x: auto;
    }

    table{
        width: 100%;
        border-collapse: collapse;
    }

    thead{
        background: #111;
        color: white;
    }

    thead th{
        padding: 18px;
        text-align: left;
        font-size: 15px;
        letter-spacing: .5px;
    }

    tbody td{
        padding: 18px;
        border-bottom: 1px solid #eee;
        color: #444;
    }

    tbody tr{
        transition: .2s;
    }

    tbody tr:hover{
        background: #f9f9f9;
    }

    .stock-alto{
        color: green;
        font-weight: bold;
    }

    .stock-bajo{
        color: red;
        font-weight: bold;
    }

    .acciones{
        display: flex;
        gap: 10px;
    }

    .btn-editar{
        background: #ffc107;
        color: #111;
        padding: 8px 14px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
    }

    .btn-eliminar{
        background: #dc3545;
        color: white;
        padding: 8px 14px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
    }

    .empty-state{
        text-align: center;
        padding: 50px;
        color: #777;
        font-size: 18px;
    }

</style>

<div class="inventario-container">

    <!-- HEADER -->
    <div class="inventario-header">

        <div>

            <h1 class="inventario-title">
                📦 Inventario de Productos
            </h1>

            <p class="inventario-subtitle">
                Administra productos, existencias y disponibilidad.
            </p>

        </div>

<a href="{{ route('admin.productos.create') }}" class="btn-agregar">
    + Agregar Producto
</a>

    </div>

    <!-- TABLA -->
    <div class="table-container">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>

            </thead>

            <tbody>

                @forelse($productos as $producto)

                    <tr>

                        <td>
                            {{ $producto->id }}
                        </td>

                        <td>
                            {{ $producto->nombre }}
                        </td>

                        <td>
                            {{ $producto->categoria }}
                        </td>

                        <td>
                        @if($producto->cantidad_disponible > 5)

                            <span class="stock-alto">
                                {{ $producto->cantidad_disponible }}
                            </span>

                        @else

                            <span class="stock-bajo">
                                {{ $producto->cantidad_disponible }}
                            </span>

                        @endif

                        </td>

                        <td>
                            ${{ number_format($producto->precio, 2) }}
                        </td>

                        <td>

<div class="acciones">

    <a href="{{ route('admin.productos.edit', $producto->id) }}"
       class="btn-editar">
        Editar
    </a>

    <a href="{{ route('admin.productos.destroy', $producto->id) }}"
       class="btn-eliminar"
       onclick="return confirm('¿Eliminar este producto?')">
        Eliminar
    </a>

</div>

                @empty

                    <tr>

                        <td colspan="6">

                            <div class="empty-state">
                                📭 No hay productos registrados.
                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection