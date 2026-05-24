@extends('cpanel.app')

@section('title', 'Carrito')

@section('content')

<style>

    body{
        background:#f4f6f9;
        font-family:Arial, Helvetica, sans-serif;
    }

    .carrito-container{
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

    .empty-cart{
        background:white;
        padding:30px;
        border-radius:20px;
        text-align:center;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
        color:#555;
        font-size:18px;
    }

    .table-container{
        background:white;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    thead{
        background:#111;
        color:white;
    }

    th{
        padding:18px;
        text-align:center;
        font-size:15px;
    }

    td{
        padding:18px;
        text-align:center;
        border-bottom:1px solid #eee;
        color:#333;
    }

    tr:hover{
        background:#f9f9f9;
    }

    .total-box{
        margin-top:25px;
        background:white;
        padding:25px;
        border-radius:20px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:20px;
    }

    .total-box h2{
        margin:0;
        color:#111;
        font-size:30px;
    }

    .btn-confirmar{
        background:#111;
        color:white;
        border:none;
        padding:15px 30px;
        border-radius:12px;
        font-size:16px;
        cursor:pointer;
        transition:.3s;
    }

    .btn-confirmar:hover{
        background:#333;
        transform:translateY(-2px);
    }

    .mensaje{
        padding:15px;
        border-radius:12px;
        margin-bottom:20px;
        font-weight:bold;
    }

    .success{
        background:#d1e7dd;
        color:#0f5132;
    }

    .error{
        background:#f8d7da;
        color:#842029;
    }

</style>

<div class="carrito-container">

    {{-- BOTÓN CERRAR --}}
    <div class="top-bar">

        <a href="{{ route('cliente.dashboard') }}"
           class="btn-close">

            ✕

        </a>

    </div>


    {{-- MENSAJES --}}
    @if(session('success'))

        <div class="mensaje success">

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="mensaje error">

            {{ session('error') }}

        </div>

    @endif


    {{-- TÍTULO --}}
    <h1 class="titulo">
        Mi Carrito 🛒
    </h1>


    {{-- CARRITO VACÍO --}}
    @if($carrito->isEmpty())

        <div class="empty-cart">

            No hay productos en tu carrito.

        </div>

    @else

        {{-- TABLA --}}
        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Producto</th>

                        <th>Precio</th>

                        <th>Cantidad</th>

                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($carrito as $item)

                        <tr>

                            <td>
                                {{ $item->nombre }}
                            </td>

                            <td>
                                ${{ number_format($item->precio, 2) }}
                            </td>

                            <td>
                                {{ $item->cantidad }}
                            </td>

                            <td>
                                ${{ number_format($item->subtotal, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- TOTAL --}}
        <div class="total-box">

            <h2>

                Total:
                ${{ number_format($total, 2) }}

            </h2>


            {{-- CONFIRMAR RENTA --}}
            <a href="{{ route('cliente.confirmar.renta.view') }}">

                @csrf

                <button type="submit"
                        class="btn-confirmar">

                    Confirmar Renta

                </button>

            </form>

        </div>

    @endif

</div>

@endsection