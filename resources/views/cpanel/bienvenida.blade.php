@extends('cpanel.app')

@section('title', 'Dashboard - Alquiladora GAOS')

@section('content')

<style>
body {
    background: #f4f6f9;
}

/* HERO */
.hero {
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    color: white;
    padding: 50px 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
}

.hero h1 {
    font-size: 32px;
    font-weight: bold;
}

.hero p {
    font-size: 16px;
    opacity: 0.9;
}

.badge-sistema {
    display: inline-block;
    background: #22c55e;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    margin-bottom: 10px;
}

/* CARDS */
.card-box {
    border-radius: 15px;
    padding: 20px;
    color: white;
    transition: 0.3s;
}

.card-box:hover {
    transform: translateY(-5px);
}

.bg-lonas { background: #2563eb; }
.bg-mesas { background: #16a34a; }
.bg-sillas { background: #f59e0b; }
.bg-carpas { background: #ef4444; }
.bg-inflables { background: #a855f7; }
.bg-brincolines { background: #06b6d4; }

.icon {
    font-size: 30px;
    margin-bottom: 10px;
}

/* PANEL INFO */
.panel-info {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

</style>

<div class="hero">
    <div class="badge-sistema">Sistema de Renta Activo</div>
    <h1>Bienvenido al Sistema GAOS</h1>
    <p>Gestión de renta de <b>lonas, mesas, sillas, carpas, inflables y brincolines</b> en un solo lugar.</p>
</div>

<div class="row g-3">

    <div class="col-md-4">
        <div class="card-box bg-lonas">
            <div class="icon">🏕️</div>
            <h4>Lonas</h4>
            <p>Control de disponibilidad y rentas activas</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box bg-mesas">
            <div class="icon">🪑</div>
            <h4>Mesas</h4>
            <p>Gestión de inventario de mesas</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box bg-sillas">
            <div class="icon">💺</div>
            <h4>Sillas</h4>
            <p>Control de piezas disponibles</p>
        </div>
    </div>

    <div class="col-md-4 mt-3">
        <div class="card-box bg-carpas">
            <div class="icon">⛺</div>
            <h4>Carpas</h4>
            <p>Rentas para eventos y fiestas</p>
        </div>
    </div>

    <div class="col-md-4 mt-3">
        <div class="card-box bg-inflables">
            <div class="icon">🎈</div>
            <h4>Inflables</h4>
            <p>Control de inflables disponibles</p>
        </div>
    </div>

    <div class="col-md-4 mt-3">
        <div class="card-box bg-brincolines">
            <div class="icon">🤸</div>
            <h4>Brincolines</h4>
            <p>Administración de rentas infantiles</p>
        </div>
    </div>

</div>

<br>

<div class="panel-info">
    <h5>📊 Panel del Sistema</h5>
    <p>
        Desde aquí puedes administrar todo el catálogo de productos de renta,
        controlar disponibilidad, clientes y reservas en tiempo real.
    </p>
</div>
<!-- BOTÓN FLOTANTE -->
<div class="logout-float">
    <a href="{{ route('cpanel.inicio') }}" class="logout-btn">
        🚪 Cerrar sesión
    </a>
</div>

<style>
.logout-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 999;
}

.logout-btn {
    display: inline-block;
    background: #ef4444;
    color: white;
    text-decoration: none;
    padding: 12px 18px;
    border-radius: 50px;
    font-size: 14px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    transition: 0.3s;
}

.logout-btn:hover {
    background: #dc2626;
    transform: scale(1.05);
}
</style>


@endsection
