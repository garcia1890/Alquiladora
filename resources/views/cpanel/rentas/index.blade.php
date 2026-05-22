@extends('cpanel.app')

@section('title', 'Rentas')

@section('content')

<style>

    body{
        background: #f4f6f9;
    }

    .page-container{
        max-width: 1400px;
        margin: auto;
        padding: 20px;
    }

    /*
    ======================================
    HEADER
    ======================================
    */

    .top-banner{
        background: linear-gradient(135deg,#111,#2d2d2d);
        color: white;
        padding: 40px;
        border-radius: 30px;
        margin-bottom: 35px;
        box-shadow: 0 15px 35px rgba(0,0,0,.12);
        position: relative;
        overflow: hidden;
    }

    .top-banner::before{
        content:'';
        position:absolute;
        width:300px;
        height:300px;
        background:rgba(255,255,255,.05);
        border-radius:50%;
        top:-120px;
        right:-80px;
    }

    .top-content{
        position: relative;
        z-index: 2;

        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:20px;
        flex-wrap:wrap;
    }

    .top-title{
        font-size:42px;
        margin-bottom:10px;
    }

    .top-description{
        opacity:.85;
        font-size:17px;
    }

    .btn-agregar{
        background:white;
        color:#111;
        text-decoration:none;
        padding:16px 24px;
        border-radius:16px;
        font-weight:bold;
        transition:.3s;
        box-shadow:0 10px 20px rgba(0,0,0,.1);
    }

    .btn-agregar:hover{
        transform:translateY(-3px);
    }

    /*
    ======================================
    TABLE
    ======================================
    */

    .table-card{
        background:white;
        border-radius:30px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    thead{
        background:#111;
        color:white;
    }

    thead th{
        padding:20px;
        text-align:left;
        font-size:15px;
        letter-spacing:.5px;
    }

    tbody td{
        padding:20px;
        border-bottom:1px solid #f1f1f1;
        font-size:15px;
        color:#444;
    }

    tbody tr{
        transition:.3s;
    }

    tbody tr:hover{
        background:#fafafa;
    }

    /*
    ======================================
    STATUS
    ======================================
    */

    .estado{
        padding:10px 16px;
        border-radius:50px;
        font-size:13px;
        font-weight:bold;
        display:inline-block;
    }

    .pendiente{
        background:#fff3cd;
        color:#856404;
    }

    .cancelado{
        background:#f8d7da;
        color:#721c24;
    }

    .completado{
        background:#d4edda;
        color:#155724;
    }

    /*
    ======================================
    BUTTONS
    ======================================
    */

    .acciones{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

    .btn-action{
        text-decoration:none;
        padding:10px 16px;
        border-radius:12px;
        font-size:14px;
        font-weight:bold;
        transition:.3s;
    }

    .btn-editar{
        background:#ffc107;
        color:#111;
    }

    .btn-editar:hover{
        transform:translateY(-2px);
    }

    .btn-eliminar{
        background:#dc3545;
        color:white;
    }

    .btn-eliminar:hover{
        transform:translateY(-2px);
    }

    /*
    ======================================
    EMPTY
    ======================================
    */

    .empty-state{
        padding:50px;
        text-align:center;
        color:#777;
    }

    .empty-state h2{
        margin-top:15px;
        font-size:28px;
    }

</style>

<div class="page-container">

    <!-- HEADER -->
    <div class="top-banner">

        <div class="top-content">

            <div>

                <h1 class="top-title">
                    📄 Gestión de Rentas
                </h1>

                <p class="top-description">
                    Administra, actualiza y controla todas las rentas del sistema.
                </p>

            </div>

            <a href="{{ route('admin.rentas.create') }}"
               class="btn-agregar">

                ➕ Agregar Renta

            </a>

        </div>

    </div>

    <!-- TABLA -->
    <div class="table-card">

        <table>

            <thead>

                <tr>

                    <th>#</th>
                    <th>Estado</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Total</th>
                    <th>Cliente</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                @forelse($rentas as $renta)

                    <tr>

                        <td>
                            #{{ $renta->id }}
                        </td>

                        <td>

                            @if($renta->estado == 'Pendiente')

                                <span class="estado pendiente">
                                    Pendiente
                                </span>

                            @elseif($renta->estado == 'Cancelado')

                                <span class="estado cancelado">
                                    Cancelado
                                </span>

                            @else

                                <span class="estado completado">
                                    Completado
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $renta->fecha_inicio }}
                        </td>

                        <td>
                            {{ $renta->fecha_fin }}
                        </td>

                        <td>
                            ${{ number_format($renta->total, 2) }}
                        </td>

                        <td>
                            Cliente #{{ $renta->cliente_id }}
                        </td>

                        <td>

                            <div class="acciones">

                                <a href="{{ route('admin.rentas.edit', $renta->id) }}"
                                   class="btn-action btn-editar">

                                    ✏️ Editar

                                </a>

                                <a href="{{ route('admin.rentas.destroy', $renta->id) }}"
                                   class="btn-action btn-eliminar"
                                   onclick="return confirm('¿Eliminar esta renta?')">

                                    🗑️ Eliminar

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">

                            <div class="empty-state">

                                <div style="font-size:60px;">
                                    📭
                                </div>

                                <h2>
                                    No hay rentas registradas
                                </h2>

                                <p>
                                    Agrega una nueva renta para comenzar.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection