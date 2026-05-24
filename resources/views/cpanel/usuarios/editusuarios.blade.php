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
        text-align:center;
    }

    .form-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:20px;
    }

    .form-group{
        margin-bottom:15px;
    }

    .full-width{
        grid-column:1 / 3;
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
        transition:.3s;
    }

    .form-control:focus{
        outline:none;
        border-color:#0d6efd;
        box-shadow:0 0 5px rgba(13,110,253,.3);
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
        justify-content:center;
        flex-wrap:wrap;
    }

    .alert{
        padding:15px;
        border-radius:10px;
        margin-bottom:20px;
    }

    .alert-danger{
        background:#f8d7da;
        color:#842029;
    }

    @media(max-width:768px){

        .form-grid{
            grid-template-columns:1fr;
        }

        .full-width{
            grid-column:auto;
        }
    }

</style>


<div class="edit-container">

    <h2>✏️ Editar Usuario</h2>

    {{-- ERRORES --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form action="{{ route('usuarios.update', $usuario->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="form-grid">

            {{-- NOMBRE --}}
            <div class="form-group">

                <label>Nombre</label>

                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $usuario->nombre) }}"
                       required
                       class="form-control">

            </div>


            {{-- APELLIDO PATERNO --}}
            <div class="form-group">

                <label>Apellido Paterno</label>

                <input type="text"
                       name="apellido_pa"
                       value="{{ old('apellido_pa', $usuario->apellido_pa) }}"
                       required
                       class="form-control">

            </div>


            {{-- APELLIDO MATERNO --}}
            <div class="form-group">

                <label>Apellido Materno</label>

                <input type="text"
                       name="apellido_ma"
                       value="{{ old('apellido_ma', $usuario->apellido_ma) }}"
                       required
                       class="form-control">

            </div>


            {{-- CORREO --}}
            <div class="form-group">

                <label>Correo</label>

                <input type="email"
                       name="correo"
                       value="{{ old('correo', $usuario->correo) }}"
                       required
                       class="form-control">

            </div>


            {{-- TELEFONO --}}
            <div class="form-group">

                <label>Teléfono</label>

                <input type="text"
                       name="telefono"
                       value="{{ old('telefono', $usuario->telefono) }}"
                       maxlength="10"
                       class="form-control">

            </div>


            {{-- CALLE --}}
            <div class="form-group">

                <label>Calle</label>

                <input type="text"
                       name="calle"
                       value="{{ old('calle', $usuario->calle) }}"
                       class="form-control">

            </div>


            {{-- NUMERO --}}
            <div class="form-group">

                <label>Número</label>

                <input type="text"
                       name="numero"
                       value="{{ old('numero', $usuario->numero) }}"
                       class="form-control">

            </div>


            {{-- CODIGO POSTAL --}}
            <div class="form-group">

                <label>Código Postal</label>

                <input type="text"
                       name="codigo_postal"
                       maxlength="10"
                       value="{{ old('codigo_postal', $usuario->codigo_postal) }}"
                       class="form-control">

            </div>


            {{-- MUNICIPIO --}}
            <div class="form-group">

                <label>Municipio</label>

                <input type="text"
                       name="municipio"
                       value="{{ old('municipio', $usuario->municipio) }}"
                       class="form-control">

            </div>


            {{-- ESTADO --}}
            <div class="form-group full-width">

                <label>Estado</label>

                <input type="text"
                       name="estado"
                       value="{{ old('estado', $usuario->estado) }}"
                       class="form-control">

            </div>


            {{-- CONTRASEÑA --}}
            <div class="form-group">

                <label>Contraseña</label>

                <input type="password"
                       name="contrasena"
                       placeholder="Dejar vacío para no cambiar"
                       class="form-control">

            </div>


            {{-- ROL --}}
            <div class="form-group">

                <label>Rol</label>

                <select name="rol_id"
                        class="form-control">

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

        </div>


        {{-- BOTONES --}}
        <div class="actions">

            <button type="submit"
                    class="btn btn-primary">

                💾 Guardar Cambios

            </button>


            <a href="{{ route('usuarios.index') }}"
               class="btn btn-secondary">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection