@extends('cpanel.app')

@section('title','Productos')

@section('content')

<style>

    .productos-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:25px;
    }

    .productos-table{
        width:100%;
        border-collapse:collapse;
        background:white;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    }

    .productos-table th{
        background:#111;
        color:white;
        padding:15px;
        text-align:left;
    }

    .productos-table td{
        padding:15px;
        border-bottom:1px solid #eee;
    }

    .productos-table tr:hover{
        background:#f9f9f9;
    }

    .btn{
        padding:10px 15px;
        border-radius:10px;
        text-decoration:none;
        font-weight:bold;
        border:none;
        cursor:pointer;
    }

    .btn-success{
        background:#198754;
        color:white;
    }

    .btn-primary{
        background:#0d6efd;
        color:white;
    }

    .btn-danger{
        background:#dc3545;
        color:white;
    }

</style>

<div class="productos-header">

    <h2>📦 Gestión de Productos</h2>

    <a href="{{ route('productos.create') }}" class="btn btn-success">
        + Agregar Producto
    </a>

</div>

<table class="productos-table">

    <thead>

        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Disponibles</th>
            <th>Acciones</th>
        </tr>

    </thead>

    <tbody>

        @forelse($productos as $producto)

        <tr>

            <td>{{ $producto->id }}</td>

            <td>{{ $producto->nombre }}</td>

            <td>{{ $producto->categoria }}</td>

            <td>${{ $producto->precio }}</td>

            <td>{{ $producto->cantidad_disponible }}</td>

            <td>

                <a href="{{ route('productos.edit', $producto->id) }}"
                   class="btn btn-primary">

                    Editar

                </a>

                <form action="{{ route('productos.destroy', $producto->id) }}"
                      method="POST"
                      style="display:inline-block;">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger"
                            onclick="return confirm('¿Eliminar producto?')">

                        Eliminar

                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="6" style="text-align:center;">
                No hay productos registrados
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

@endsection