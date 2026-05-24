@extends('cpanel.app')

@section('title', 'Mi Perfil')

@section('content')

<style>

    body{
        font-family:'Segoe UI', sans-serif;
        background:#e9ecef;
        min-height:100vh;
    }

    .perfil-container{
        width:95%;
        max-width:1150px;
        margin:40px auto;
    }

    .perfil-card{
        position:relative;
        background:#ffffff;
        border-radius:28px;
        padding:45px;
        box-shadow:
            0 10px 30px rgba(0,0,0,.08);
        border:1px solid #e5e5e5;
        overflow:hidden;
    }

    /* ✕ CERRAR */
    .btn-close{
        position:absolute;
        top:22px;
        right:22px;
        width:46px;
        height:46px;
        border-radius:50%;
        background:#f3f3f3;
        color:#333;
        text-decoration:none;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:22px;
        font-weight:bold;
        transition:.3s;
        border:1px solid #ddd;
    }

    .btn-close:hover{
        background:#111;
        color:white;
        transform:rotate(90deg);
    }

    /* HEADER */
    .perfil-header{
        text-align:center;
        margin-bottom:40px;
    }

    .perfil-avatar{
        width:110px;
        height:110px;
        border-radius:50%;
        background:#111;
        color:white;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:42px;
        margin:auto;
        margin-bottom:22px;
        box-shadow:
            0 8px 20px rgba(0,0,0,.18);
    }

    .perfil-header h1{
        font-size:38px;
        color:#111;
        margin-bottom:8px;
        font-weight:700;
    }

    .perfil-header p{
        color:#666;
        font-size:15px;
    }

    /* SUCCESS */
    .success{
        background:#f5f5f5;
        color:#111;
        border-left:5px solid #111;
        padding:18px;
        border-radius:14px;
        margin-bottom:30px;
        font-weight:600;
    }

    /* TITULOS */
    .section-title{
        margin-top:20px;
        margin-bottom:25px;
        font-size:20px;
        font-weight:700;
        color:#111;
        padding-bottom:12px;
        border-bottom:2px solid #ececec;
    }

    /* GRID */
    .form-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:24px;
    }

    .form-group{
        display:flex;
        flex-direction:column;
    }

    .full-width{
        grid-column:1 / 3;
    }

    /* LABEL */
    label{
        font-weight:600;
        margin-bottom:10px;
        color:#222;
        font-size:14px;
    }

    /* INPUTS */
    input{
        width:100%;
        padding:15px;
        border-radius:16px;
        border:1px solid #dcdcdc;
        background:#fafafa;
        font-size:15px;
        transition:.3s;
        box-sizing:border-box;
        color:#111;
    }

    input:focus{
        outline:none;
        border-color:#111;
        background:white;
        box-shadow:
            0 0 0 4px rgba(0,0,0,.06);
        transform:translateY(-1px);
    }

    input:disabled{
        background:#ededed;
        color:#666;
        cursor:not-allowed;
    }

    /* PASSWORD */
    .password-preview{
        background:#f1f1f1;
        border:1px solid #ddd;
        padding:15px;
        border-radius:16px;
        letter-spacing:4px;
        color:#555;
    }

    .password-note{
        margin-top:8px;
        font-size:13px;
        color:#777;
    }

    /* BOTON */
    .btn-save{
        width:100%;
        border:none;
        margin-top:40px;
        padding:18px;
        border-radius:18px;
        background:#111;
        color:white;
        font-size:16px;
        font-weight:700;
        cursor:pointer;
        transition:.3s;
        letter-spacing:.5px;
    }

    .btn-save:hover{
        background:#000;
        transform:translateY(-2px);
        box-shadow:
            0 10px 20px rgba(0,0,0,.15);
    }

    /* RESPONSIVE */
    @media(max-width:768px){

        .perfil-card{
            padding:28px;
        }

        .form-grid{
            grid-template-columns:1fr;
        }

        .full-width{
            grid-column:auto;
        }

        .perfil-header h1{
            font-size:30px;
        }

    }

</style>

<div class="perfil-container">

```
<div class="perfil-card">

    {{-- ✕ CERRAR --}}
    <a href="{{ url('cliente/dashboard') }}"
       class="btn-close">

        ✕

    </a>


    {{-- HEADER --}}
    <div class="perfil-header">

        <div class="perfil-avatar">

            👤

        </div>

        <h1>

            Mi Perfil

        </h1>

        <p>

            Administra tu información personal y mantén segura tu cuenta.

        </p>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="success">

            {{ session('success') }}

        </div>

    @endif


    {{-- FORM --}}
    <form action="{{ route('cliente.actualizarPerfil') }}"
          method="POST">

        @csrf


        {{-- INFORMACION --}}
        <div class="section-title">

            Información Personal

        </div>


        <div class="form-grid">

            {{-- NOMBRE --}}
            <div class="form-group">

                <label>Nombre</label>

                <input type="text"
                       value="{{ $usuario->nombre }}"
                       disabled>

            </div>


            {{-- APELLIDO PATERNO --}}
            <div class="form-group">

                <label>Apellido Paterno</label>

                <input type="text"
                       value="{{ $usuario->apellido_pa ?? '' }}"
                       disabled>

            </div>


            {{-- APELLIDO MATERNO --}}
            <div class="form-group">

                <label>Apellido Materno</label>

                <input type="text"
                       value="{{ $usuario->apellido_ma ?? '' }}"
                       disabled>

            </div>


            {{-- CORREO --}}
            <div class="form-group">

                <label>Correo</label>

                <input type="email"
                       name="correo"
                       value="{{ old('correo', $usuario->correo) }}">

            </div>


            {{-- TELEFONO --}}
            <div class="form-group">

                <label>Teléfono</label>

                <input type="text"
                       name="telefono"
                       maxlength="10"
                       value="{{ old('telefono', $usuario->telefono) }}">

            </div>

        </div>


        {{-- DIRECCION --}}
        <div class="section-title">

            Dirección

        </div>


        <div class="form-grid">

            {{-- CALLE --}}
            <div class="form-group">

                <label>Calle</label>

                <input type="text"
                       name="calle"
                       value="{{ old('calle', $usuario->calle) }}">

            </div>


            {{-- NUMERO --}}
            <div class="form-group">

                <label>Número</label>

                <input type="text"
                       name="numero"
                       value="{{ old('numero', $usuario->numero) }}">

            </div>


            {{-- CODIGO POSTAL --}}
            <div class="form-group">

                <label>Código Postal</label>

                <input type="text"
                       name="codigo_postal"
                       maxlength="10"
                       value="{{ old('codigo_postal', $usuario->codigo_postal) }}">

            </div>


            {{-- MUNICIPIO --}}
            <div class="form-group">

                <label>Municipio</label>

                <input type="text"
                       name="municipio"
                       value="{{ old('municipio', $usuario->municipio) }}">

            </div>


            {{-- ESTADO --}}
            <div class="form-group full-width">

                <label>Estado</label>

                <input type="text"
                       name="estado"
                       value="{{ old('estado', $usuario->estado) }}">

            </div>

        </div>


        {{-- SEGURIDAD --}}
        <div class="section-title">

            Seguridad

        </div>


        <div class="form-grid">

            {{-- PASSWORD ACTUAL --}}
            <div class="form-group">

                <label>Contraseña Actual</label>

                <div class="password-preview">

                    ********

                </div>

                <span class="password-note">

                    Tu contraseña está protegida.

                </span>

            </div>


            {{-- NUEVA PASSWORD --}}
            <div class="form-group">

                <label>Nueva Contraseña</label>

                <input type="password"
                       name="contrasena"
                       minlength="8"
                       placeholder="Escribe una nueva contraseña">

                <span class="password-note">

                    Déjalo vacío si no deseas cambiarla.

                </span>

            </div>


            {{-- CONFIRMAR --}}
            <div class="form-group full-width">

                <label>Confirmar Nueva Contraseña</label>

                <input type="password"
                       name="contrasena_confirmation"
                       minlength="8"
                       placeholder="Confirma tu nueva contraseña">

            </div>

        </div>


        {{-- BOTON --}}
        <button type="submit"
                class="btn-save">

            Guardar Cambios

        </button>

    </form>

</div>
```

</div>

@endsection
