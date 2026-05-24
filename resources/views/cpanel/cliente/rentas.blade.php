@extends('cpanel.app')

@section('title', 'Mis Rentas')

@section('content')

<style>

    body{
        background:#f4f6f9;
        font-family:Arial, Helvetica, sans-serif;
    }

    .rentas-container{
        width:100%;
    }

    .top-bar{
        display:flex;
        justify-content:flex-end;
        margin-bottom:15px;
    }

    .btn-close{
        width:42px;
        height:42px;
        background:#111;
        color:white;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        text-decoration:none;
        font-size:20px;
        font-weight:bold;
        transition:.3s;
        box-shadow:0 5px 15px rgba(0,0,0,.15);
    }

    .btn-close:hover{
        background:#333;
        transform:scale(1.05);
    }

    .titulo{
        font-size:35px;
        margin-bottom:30px;
        color:#111;
    }

    .renta-card{
        background:white;
        border-radius:20px;
        padding:25px;
        margin-bottom:25px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    }

    .renta-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:15px;
        margin-bottom:20px;
        border-bottom:1px solid #eee;
        padding-bottom:15px;
    }

    .estado{
        padding:10px 18px;
        border-radius:50px;
        color:white;
        font-size:14px;
        font-weight:bold;
    }

    .pendiente{
        background:#ffc107;
        color:#111;
    }

    .confirmada{
        background:#0d6efd;
    }

    .entregada{
        background:#6610f2;
    }

    .devuelta{
        background:#20c997;
    }

    .completada{
        background:#198754;
    }

    .cancelada{
        background:#dc3545;
    }

    .info{
        margin-top:10px;
        color:#555;
        line-height:1.8;
    }

    .detalle-table{
        width:100%;
        border-collapse:collapse;
        margin-top:20px;
    }

    .detalle-table thead{
        background:#111;
        color:white;
    }

    .detalle-table th{
        padding:15px;
        text-align:center;
    }

    .detalle-table td{
        padding:15px;
        text-align:center;
        border-bottom:1px solid #eee;
    }

    .total{
        text-align:right;
        margin-top:20px;
        font-size:24px;
        font-weight:bold;
        color:#111;
    }

    .empty{
        background:white;
        padding:40px;
        border-radius:20px;
        text-align:center;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
        color:#666;
        font-size:18px;
    }

</style>

<div class="rentas-container">

    {{-- BOTÓN REGRESAR --}}
    <div class="top-bar">

        <a href="{{ route('cliente.dashboard') }}"
           class="btn-close">

            ✕

        </a>

    </div>

    <h1 class="titulo">

        Mis Rentas 📦

    </h1>

    @if($rentas->isEmpty())

        <div class="empty">

            Aún no has realizado ninguna renta.

        </div>

    @else

        @foreach($rentas as $renta)

            <div class="renta-card">

                {{-- HEADER --}}
                <div class="renta-header">

                    <div>

                        <h2>

                            Renta #{{ $renta->id }}

                        </h2>

                        <div class="info">

                            Fecha inicio:
                            {{ $renta->fecha_inicio }}

                            <br>

                            Fecha fin:
                            {{ $renta->fecha_fin }}

                        </div>

                    </div>

                    <div>

                        <span class="estado
                            {{ strtolower($renta->estado) }}">

                            {{ $renta->estado }}

                        </span>

                    </div>

                </div>


                {{-- PRODUCTOS --}}
                <table class="detalle-table">

                    <thead>

                        <tr>

                            <th>Producto</th>

                            <th>Precio</th>

                            <th>Cantidad</th>

                            <th>Subtotal</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($renta->detalles as $detalle)

                            <tr>

                                <td>

                                    {{ $detalle->nombre }}

                                </td>

                                <td>

                                    ${{ number_format($detalle->precio_unitario, 2) }}

                                </td>

                                <td>

                                    {{ $detalle->cantidad }}

                                </td>

                                <td>

                                    ${{ number_format($detalle->subtotal, 2) }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>


                {{-- TOTAL --}}
                <div class="total">

                    Total:
                    ${{ number_format($renta->total, 2) }}

                </div>

            </div>

        @endforeach

    @endif

@endsection