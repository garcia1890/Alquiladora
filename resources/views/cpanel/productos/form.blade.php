<style>

    .form-container{
        max-width:700px;
        margin:auto;
        background:white;
        padding:35px;
        border-radius:20px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    }

    .form-group{
        margin-bottom:20px;
    }

    .form-group label{
        display:block;
        margin-bottom:8px;
        font-weight:bold;
    }

    .form-control{
        width:100%;
        padding:12px;
        border:1px solid #ccc;
        border-radius:10px;
    }

    .btn{
        padding:12px 20px;
        border:none;
        border-radius:10px;
        cursor:pointer;
        text-decoration:none;
        font-weight:bold;
    }

    .btn-success{
        background:#198754;
        color:white;
    }

    .btn-secondary{
        background:#6c757d;
        color:white;
    }

</style>

<div class="form-container">

    <h2>

        {{ isset($producto) ? '✏️ Editar Producto' : '➕ Agregar Producto' }}

    </h2>

    <form action="
        {{ isset($producto)
            ? route('productos.update', $producto->id)
            : route('productos.store')
        }}
    "
    method="POST">

        @csrf

        @if(isset($producto))
            @method('PUT')
        @endif

        <div class="form-group">

            <label>Nombre</label>

            <input type="text"
                   name="nombre"
                   class="form-control"
                   required
                   value="{{ $producto->nombre ?? '' }}">

        </div>


        <div class="form-group">

            <label>Descripción</label>

            <textarea name="descripcion"
                      class="form-control"
                      rows="4">{{ $producto->descripcion ?? '' }}</textarea>

        </div>


        <div class="form-group">

            <label>Precio</label>

            <input type="number"
                   step="0.01"
                   name="precio"
                   class="form-control"
                   required
                   value="{{ $producto->precio ?? '' }}">

        </div>


        <div class="form-group">

            <label>Cantidad Disponible</label>

            <input type="number"
                   name="cantidad_disponible"
                   class="form-control"
                   required
                   value="{{ $producto->cantidad_disponible ?? '' }}">

        </div>


        <div class="form-group">

            <label>Categoría</label>

            <select name="categoria" class="form-control">

                <option value="Mesa">Mesa</option>
                <option value="Silla">Silla</option>
                <option value="Carpa">Carpa</option>
                <option value="Lona">Lona</option>
                <option value="Inflable">Inflable</option>
                <option value="Accesorio">Accesorio</option>

            </select>

        </div>


        <button type="submit" class="btn btn-success">

            {{ isset($producto) ? 'Actualizar' : 'Guardar' }}

        </button>

        <a href="{{ route('productos.index') }}"
           class="btn btn-secondary">

            Cancelar

        </a>

    </form>

</div>