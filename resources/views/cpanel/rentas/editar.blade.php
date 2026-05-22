@extends('cpanel.app')

@section('title', 'Editar Renta')

@section('content')

<style>

    body{
        background: #f4f6f9;
    }

    .page-container{
        max-width: 1100px;
        margin: auto;
        padding: 20px;
    }

    .top-banner{
        background: linear-gradient(135deg,#111,#2f2f2f);
        color: white;
        padding: 40px;
        border-radius: 30px;
        margin-bottom: 35px;
        box-shadow: 0 15px 35px rgba(0,0,0,.12);
        position: relative;
        overflow: hidden;
    }

    .top-banner::before{
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,.05);
        border-radius: 50%;
        top: -120px;
        right: -80px;
    }

    .top-banner h1{
        font-size: 42px;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
    }

    .top-banner p{
        opacity: .85;
        font-size: 17px;
        position: relative;
        z-index: 2;
    }

    .icon-box{
        width: 75px;
        height: 75px;
        background: rgba(255,255,255,.1);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 35px;
        margin-bottom: 20px;
    }

    .form-card{
        background: white;
        border-radius: 30px;
        padding: 45px;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
    }

    .form-grid{
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(300px,1fr));
        gap: 25px;
    }

    .form-group{
        display: flex;
        flex-direction: column;
    }

    .form-label{
        font-weight: 700;
        margin-bottom: 10px;
        color: #222;
        font-size: 15px;
    }

    .form-control{
        border: 2px solid #ececec;
        border-radius: 16px;
        padding: 16px 18px;
        font-size: 16px;
        transition: .3s;
        background: #fafafa;
    }

    .form-control:focus{
        outline: none;
        border-color: #111;
        background: white;
        box-shadow: 0 0 0 4px rgba(0,0,0,.05);
    }

    .button-container{
        margin-top: 35px;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn{
        padding: 15px 28px;
        border-radius: 16px;
        border: none;
        cursor: pointer;
        font-size: 15px;
        font-weight: 700;
        transition: .3s;
        text-decoration: none;
    }

    .btn-back{
        background: #ececec;
        color: #333;
    }

    .btn-back:hover{
        background: #ddd;
    }

    .btn-save{
        background: linear-gradient(135deg,#111,#2c2c2c);
        color: white;
        box-shadow: 0 10px 20px rgba(0,0,0,.12);
    }

    .btn-save:hover{
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(0,0,0,.18);
    }

</style>

<div class="page-container">

    <!-- HEADER -->
    <div class="top-banner">

        <div class="icon-box">
            📄
        </div>

        <h1>
            Editar Renta
        </h1>

        <p>
            Actualiza la información de la renta dentro del sistema de Alquiladora GAOS.
        </p>

    </div>

    <!-- FORMULARIO -->
    <div class="form-card">

        <form action="{{ route('admin.rentas.update', $renta->id) }}"
              method="POST">

            @csrf

            <div class="form-grid">

                <!-- ESTADO -->
                <div class="form-group">

                    <label class="form-label">
                        Estado de la renta
                    </label>

                    <select name="estado"
                            class="form-control">

                        <option value="Pendiente"
                            {{ $renta->estado == 'Pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>

                        <option value="Cancelado"
                            {{ $renta->estado == 'Cancelado' ? 'selected' : '' }}>
                            Cancelado
                        </option>

                        <option value="Completado"
                            {{ $renta->estado == 'Completado' ? 'selected' : '' }}>
                            Completado
                        </option>

                    </select>

                </div>

                <!-- TOTAL -->
                <div class="form-group">

                    <label class="form-label">
                        Total
                    </label>

                    <input type="number"
                           step="0.01"
                           name="total"
                           class="form-control"
                           value="{{ $renta->total }}">

                </div>

                <!-- FECHA INICIO -->
                <div class="form-group">

                    <label class="form-label">
                        Fecha de inicio
                    </label>

                    <input type="date"
                           name="fecha_inicio"
                           class="form-control"
                           value="{{ $renta->fecha_inicio }}">

                </div>

                <!-- FECHA FIN -->
                <div class="form-group">

                    <label class="form-label">
                        Fecha de finalización
                    </label>

                    <input type="date"
                           name="fecha_fin"
                           class="form-control"
                           value="{{ $renta->fecha_fin }}">

                </div>

                <!-- CLIENTE -->
                <div class="form-group" style="grid-column: 1 / -1;">

                    <label class="form-label">
                        Cliente
                    </label>

                    <select name="cliente_id"
                            class="form-control">

                        @foreach($clientes as $cliente)

                            <option value="{{ $cliente->id }}"
                                {{ $renta->cliente_id == $cliente->id ? 'selected' : '' }}>

                                Cliente #{{ $cliente->id }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <!-- BOTONES -->
            <div class="button-container">

                <a href="{{ route('admin.rentas.index') }}"
                   class="btn btn-back">

                    ← Volver

                </a>

                <button type="submit"
                        class="btn btn-save">

                    💾 Actualizar Renta

                </button>

            </div>

        </form>

    </div>

</div>

@endsection