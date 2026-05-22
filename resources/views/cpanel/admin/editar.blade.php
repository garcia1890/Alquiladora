@extends('cpanel.app')

@section('title', 'Editar Producto')

@section('content')

<style>

    .form-container{
        max-width: 800px;
        margin: auto;
        background: white;
        padding: 40px;
        border-radius: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
    }

    .form-title{
        font-size: 32px;
        margin-bottom: 30px;
    }

    .form-group{
        margin-bottom: 20px;
    }

    .form-group label{
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .form-control{
        width: 100%;
        padding: 14px;
        border: 1px solid #ccc;
        border-radius: 12px;
        font-size: 16px;
    }

    textarea.form-control{
        min-height: 120px;
        resize: vertical;
    }

    .btn-guardar{
        background: #111;
        color: white;
        border: none;
        padding: 14px 25px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 16px;
    }

</style>

<div class="form-container">

    <h1 class="form-title">
        ✏️ Editar Producto
    </h1>

    <form action="{{ route('admin.productos.update', $producto->id) }}"
          method="POST">

        @csrf

        <div class="form-group">

            <label>Nombre</label>

            <input type="text"
                   name="nombre"
                   class="form-control"
                   value="{{ $producto->nombre }}">

        </div>

        <div class="form-group">

            <label>Descripción</label>

            <textarea name="descripcion"
                      class="form-control">{{ $producto->descripcion }}</textarea>

        </div>

        <div class="form-group">

            <label>Precio</label>

            <input type="number"
                   step="0.01"
                   name="precio"
                   class="form-control"
                   value="{{ $producto->precio }}">

        </div>

        <div class="form-group">

            <label>Cantidad disponible</label>

            <input type="number"
                   name="cantidad_disponible"
                   class="form-control"
                   value="{{ $producto->cantidad_disponible }}">

        </div>

        <div class="form-group">

            <label>Categoría</label>

            <select name="categoria" class="form-control">

                <option value="Accesorio" {{ $producto->categoria == 'Accesorio' ? 'selected' : '' }}>
                    Accesorio
                </option>

                <option value="Carpa" {{ $producto->categoria == 'Carpa' ? 'selected' : '' }}>
                    Carpa
                </option>

                <option value="Lona" {{ $producto->categoria == 'Lona' ? 'selected' : '' }}>
                    Lona
                </option>

                <option value="Mesa" {{ $producto->categoria == 'Mesa' ? 'selected' : '' }}>
                    Mesa
                </option>

                <option value="Silla" {{ $producto->categoria == 'Silla' ? 'selected' : '' }}>
                    Silla
                </option>

                <option value="Inflable" {{ $producto->categoria == 'Inflable' ? 'selected' : '' }}>
                    Inflable
                </option>

            </select>

        </div>

        <button type="submit" class="btn-guardar">
            Guardar Cambios
        </button>

    </form>

</div>
