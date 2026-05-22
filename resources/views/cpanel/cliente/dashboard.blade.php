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