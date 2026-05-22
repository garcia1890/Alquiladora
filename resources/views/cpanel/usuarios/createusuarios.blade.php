@extends('cpanel.app')

@section('title','Agregar Usuario')

@section('content')

<style>

    .create-container{
        max-width:700px;
        margin:auto;
        background:white;
        padding:35px;
        border-radius:20px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    }

    .create-container h2{
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
        border-color:#198754;
        box-shadow:0 0 5px rgba(25,135,84,.3);
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

    .btn-success{
        background:#198754;
        color:white;
    }

    .btn-success:hover{
        background:#157347;
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

    .alert-success{
        background:#d1e7dd;
        color:#0f5132;
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


<div class="create-container">

    <h2>➕ Agregar Usuario</h2>

    {{-- MENSAJES DE ERROR --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- MENSAJE SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    <form action="{{ route('usuarios.store') }}"
          method="POST">

        @csrf

        <div class="form-grid">

            {{-- NOMBRE --}}
            <div class="form-group">

                <label>Nombre</label>

                <input type="text"
                       name="nombre"
                       required
                       value="{{ old('nombre') }}"
                       pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+"
                       class="form-control">

            </div>


            {{-- APELLIDO PATERNO --}}
            <div class="form-group">

                <label>Apellido Paterno</label>

                <input type="text"
                       name="apellido_pa"
                       required
                       value="{{ old('apellido_pa') }}"
                       pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+"
                       class="form-control">

            </div>


            {{-- APELLIDO MATERNO --}}
            <div class="form-group">

                <label>Apellido Materno</label>

                <input type="text"
                       name="apellido_ma"
                       required
                       value="{{ old('apellido_ma') }}"
                       pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+"
                       class="form-control">

            </div>


            {{-- CORREO --}}
            <div class="form-group">

                <label>Correo</label>

                <input type="email"
                       name="correo"
                       required
                       value="{{ old('correo') }}"
                       class="form-control">

            </div>


            {{-- TELEFONO --}}
            <div class="form-group">

                <label>Teléfono</label>

                <input type="text"
                       name="telefono"
                       required
                       maxlength="10"
                       minlength="10"
                       value="{{ old('telefono') }}"
                       pattern="[0-9]+"
                       class="form-control">

            </div>


            {{-- CONTRASEÑA --}}
            <div class="form-group">

                <label>Contraseña</label>

                <input type="password"
                       name="contrasena"
                       required
                       minlength="8"
                       maxlength="50"
                       class="form-control">

            </div>


            {{-- ROL --}}
            <div class="form-group full-width">

                <label>Rol</label>

                <select name="rol_id"
                        required
                        class="form-control">

                    <option value="1">
                        Administrador
                    </option>

                    <option value="2" selected>
                        Cliente
                    </option>

                    <option value="3">
                        Empleado
                    </option>

                </select>

            </div>

        </div>


        {{-- BOTONES --}}
        <div class="actions">

            <button type="submit"
                    class="btn btn-success">

                💾 Guardar Usuario

            </button>


            <a href="{{ route('usuarios.index') }}"
               class="btn btn-secondary">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection