@extends('cpanel.app')

@section('title','Editar Usuario')

@section('content')

<style>

    .edit-container{
        max-width:700px;
        margin:auto;
        background:white;
        padding:35px;
        border-radius:20px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    }

    .edit-container h2{
        margin-bottom:25px;
        color:#222;
        font-size:30px;
    }

    .form-group{
        margin-bottom:20px;
    }

    .form-group label{
        display:block;
        margin-bottom:8px;
        font-weight:bold;
        color:#333;
    }

    .form-control{
        width:100%;
        padding:12px;
        border:1px solid #ccc;
        border-radius:10px;
        font-size:15px;
    }

    .form-control:focus{
        outline:none;
        border-color:#0d6efd;
    }

    .btn{
        padding:12px 20px;
        border:none;
        border-radius:10px;
        cursor:pointer;
        text-decoration:none;
        font-weight:bold;
        transition:.3s;
    }

    .btn-primary{
        background:#0d6efd;
        color:white;
    }

    .btn-primary:hover{
        background:#0b5ed7;
    }

    .btn-secondary{
        background:#6c757d;
        color:white;
    }

    .btn-secondary:hover{
        background:#5c636a;
    }

    .actions{
        margin-top:25px;
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

</style>


<div class="edit-container">

    <h2>✏️ Editar Usuario</h2>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>

            <input type="text"
                   name="nombre"
                   value="{{ $usuario->nombre }}"
                   required
                   class="form-control">
        </div>


        <div class="form-group">
            <label>Apellido Paterno</label>

            <input type="text"
                   name="apellido_pa"
                   value="{{ $usuario->apellido_pa }}"
                   required
                   class="form-control">
        </div>


        <div class="form-group">
            <label>Apellido Materno</label>

            <input type="text"
                   name="apellido_ma"
                   value="{{ $usuario->apellido_ma }}"
                   required
                   class="form-control">
        </div>


        <div class="form-group">
            <label>Correo</label>

            <input type="email"
                   name="correo"
                   value="{{ $usuario->correo }}"
                   required
                   class="form-control">
        </div>


        <div class="form-group">
            <label>Teléfono</label>

            <input type="text"
                   name="telefono"
                   value="{{ $usuario->telefono }}"
                   class="form-control">
        </div>


        <div class="form-group">
            <label>Contraseña</label>

            <input type="password"
                   name="contrasena"
                   placeholder="Dejar vacío para no cambiar"
                   class="form-control">
        </div>


        <div class="form-group">
            <label>Rol</label>

            <select name="rol_id" class="form-control">

                <option value="1"
                    {{ $usuario->rol_id == 1 ? 'selected' : '' }}>
                    Administrador
                </option>

                <option value="2"
                    {{ $usuario->rol_id == 2 ? 'selected' : '' }}>
                    Cliente
                </option>

                <option value="3"
                    {{ $usuario->rol_id == 3 ? 'selected' : '' }}>
                    Empleado
                </option>

            </select>

        </div>


        <div class="actions">

            <button type="submit" class="btn btn-primary">
                Guardar Cambios
            </button>


            <a href="{{ route('usuarios.index') }}"
               class="btn btn-secondary">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection