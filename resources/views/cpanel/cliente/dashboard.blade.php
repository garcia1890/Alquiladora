@extends('cpanel.app')

@section('title', 'Dashboard Cliente')

@section('content')

<style>

    .welcome-banner{
        background: linear-gradient(135deg, #0d6efd, #4dabff);
        color:white;
        padding:40px;
        border-radius:25px;
        margin-bottom:30px;
        box-shadow:0 10px 25px rgba(0,0,0,.1);
    }

    .welcome-banner h1{
        font-size:38px;
        margin-bottom:10px;
    }

    .welcome-banner p{
        font-size:18px;
        opacity:.9;
    }

    /*
    |--------------------------------------------------------------------------
    | MENU CLIENTE
    |--------------------------------------------------------------------------
    */

    .top-actions{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;
        margin-bottom:30px;
    }

    .action-card{
        background:white;
        padding:25px;
        border-radius:20px;
        text-decoration:none;
        color:#222;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
        transition:.3s;
    }

    .action-card:hover{
        transform:translateY(-5px);
        color:#0d6efd;
    }

    .action-icon{
        font-size:40px;
        margin-bottom:10px;
    }

    .action-card h3{
        margin-bottom:8px;
    }

    .action-card p{
        color:#666;
        font-size:15px;
    }

    /*
    |--------------------------------------------------------------------------
    | CATEGORÍAS
    |--------------------------------------------------------------------------
    */

    .cards-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;
        margin-top:20px;
    }

    .card{
        background:white;
        padding:30px;
        border-radius:20px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
        transition:.3s;
        text-decoration:none;
        color:#222;
    }

    .card:hover{
        transform:translateY(-5px);
    }

    .card-icon{
        font-size:45px;
        margin-bottom:15px;
    }

    .card h3{
        margin-bottom:10px;
    }

    /*
    |--------------------------------------------------------------------------
    | ESTADÍSTICAS
    |--------------------------------------------------------------------------
    */

    .stats{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
        gap:20px;
        margin-top:35px;
    }

    .stat-box{
        background:white;
        padding:25px;
        border-radius:20px;
        text-align:center;
        box-shadow:0 5px 15px rgba(0,0,0,.08);
    }

    .stat-box h2{
        font-size:35px;
        color:#0d6efd;
    }

    .stat-box p{
        margin-top:10px;
        color:#555;
    }

</style>
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="GAOS2"
  agent-id="8562d840-70e5-4ab8-931a-308807bc9ff0"
  language-code="es"
></df-messenger>

{{-- MENU CLIENTE --}}
<div class="top-actions">

    {{-- PERFIL --}}
    <a href="{{ route('cliente.perfil') }}" class="action-card">

        <div class="action-icon">👤</div>

        <h3>Mi Perfil</h3>

        <p>
            Edita tu información personal.
        </p>

    </a>


    {{-- CARRITO --}}
    <a href="{{ route('cliente.carrito') }}" class="action-card">

        <div class="action-icon">🛒</div>

        <h3>Carrito</h3>

        <p>
            Consulta tus productos agregados.
        </p>

    </a>


    {{-- RENTAS --}}
    <a href="{{ route('cliente.rentas') }}" class="action-card">

        <div class="action-icon">📦</div>

        <h3>Mis Rentas</h3>

        <p>
            Visualiza tus rentas activas.
        </p>

    </a>


    {{-- FAVORITOS --}}
    <a href="#" class="action-card">

        <div class="action-icon">❤️</div>

        <h3>Favoritos</h3>

        <p>
            Guarda tus productos favoritos.
        </p>

    </a>

</div>


{{-- BIENVENIDA --}}
<div class="welcome-banner">

    <h1>
        Bienvenido {{ session('usuario_nombre') }} 👋
    </h1>

    <p>
        Explora nuestros productos y realiza tus rentas fácilmente.
    </p>

</div>


{{-- CATEGORÍAS --}}
<div class="cards-grid">

    <a href="#" class="card">

        <div class="card-icon">🪑</div>

        <h3>Mesas</h3>

        <p>
            Diferentes modelos para tus eventos.
        </p>

    </a>


    <a href="#" class="card">

        <div class="card-icon">💺</div>

        <h3>Sillas</h3>

        <p>
            Sillas elegantes y cómodas.
        </p>

    </a>


    <a href="#" class="card">

        <div class="card-icon">⛺</div>

        <h3>Carpas</h3>

        <p>
            Carpas resistentes para exteriores.
        </p>

    </a>


    <a href="#" class="card">

        <div class="card-icon">🎈</div>

        <h3>Inflables</h3>

        <p>
            Diversión para fiestas y eventos.
        </p>

    </a>

</div>

//productos disponibles
<div style="margin-top:50px;">

    <h2 style="margin-bottom:20px;">
        Productos Disponibles
    </h2>

    <div class="cards-grid">

        @foreach($productos as $producto)

            <div class="card">

                <h3>
                    {{ $producto->nombre }}
                </h3>

                <p>
                    {{ $producto->descripcion }}
                </p>

                <h2 style="margin:15px 0;">
                    ${{ $producto->precio }}
                </h2>

                <p>
                    Stock:
                    {{ $producto->stock_disponible }}
                </p>

                <form action="{{ route('cliente.agregar.carrito') }}"
                      method="POST">

                    @csrf

                    <input type="hidden"
                           name="producto_id"
                           value="{{ $producto->id }}">

                    <input type="number"
                           name="cantidad"
                           value="1"
                           min="1"
                           max="{{ $producto->stock_disponible }}"
                           style="
                                width:100%;
                                padding:10px;
                                margin:10px 0;
                           ">

                    <button type="submit"
                            style="
                                width:100%;
                                background:#111;
                                color:white;
                                border:none;
                                padding:12px;
                                border-radius:10px;
                            ">

                        Agregar al carrito 🛒

                    </button>

                </form>

            </div>

        @endforeach

    </div>

</div>


{{-- ESTADÍSTICAS --}}
<div class="stats">

    <div class="stat-box">

        <h2>0</h2>

        <p>Rentas activas</p>

    </div>


    <div class="stat-box">

        <h2>0</h2>

        <p>Pagos pendientes</p>

    </div>


    <div class="stat-box">

        <h2>0</h2>

        <p>Eventos realizados</p>

    </div>

</div>

@endsection