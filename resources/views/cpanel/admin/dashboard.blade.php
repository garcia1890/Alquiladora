@extends('cpanel.app')

@section('title', 'Dashboard Administrador')

@section('content')

<style>

    .dashboard-container{
        max-width:1400px;
        margin:auto;
    }

    /*
    ======================================
    WELCOME
    ======================================
    */

    .welcome-banner{
        background:linear-gradient(135deg,#111,#2d2d2d);
        color:white;

        padding:45px;
        border-radius:25px;

        margin-bottom:35px;

        box-shadow:0 10px 30px rgba(0,0,0,.15);
    }

    .welcome-banner h1{
        font-size:42px;
        margin-bottom:10px;
    }

    .welcome-banner p{
        font-size:18px;
        opacity:.85;
    }

    .admin-badge{
        display:inline-block;

        margin-top:18px;

        background:#ffffff20;

        padding:10px 18px;

        border-radius:50px;

        font-size:14px;
        letter-spacing:.5px;
    }

    /*
    ======================================
    STATS
    ======================================
    */

    .stats-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;

        margin-bottom:40px;
    }

    .stat-card{
        background:white;
        padding:30px;
        border-radius:20px;

        box-shadow:0 5px 15px rgba(0,0,0,.08);

        transition:.3s;
    }

    .stat-card:hover{
        transform:translateY(-5px);
    }

    .stat-icon{
        font-size:40px;
        margin-bottom:15px;
    }

    .stat-number{
        font-size:32px;
        font-weight:bold;
        margin-bottom:5px;
    }

    .stat-label{
        color:#666;
    }

    /*
    ======================================
    MODULES
    ======================================
    */

    .modules-title{
        font-size:28px;
        margin-bottom:25px;
        color:#222;
    }

    .modules-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
        gap:25px;
    }

    .module-card{
        background:white;
        border-radius:22px;

        padding:35px;

        text-decoration:none;
        color:#222;

        transition:.3s;

        box-shadow:0 5px 15px rgba(0,0,0,.08);
    }

    .module-card:hover{
        transform:translateY(-6px);
        box-shadow:0 10px 25px rgba(0,0,0,.12);
    }

    .module-icon{
        font-size:50px;
        margin-bottom:20px;
    }

    .module-card h3{
        font-size:24px;
        margin-bottom:10px;
    }

    .module-card p{
        color:#666;
        line-height:1.6;
    }

</style>

<div class="dashboard-container">

    <!-- BIENVENIDA -->
    <div class="welcome-banner">

        <h1>
            Bienvenido {{ session('usuario_nombre') }} 👋
        </h1>

        <p>
            ¿Qué deseas administrar hoy en Alquiladora GAOS?
        </p>

        <div class="admin-badge">
            👑 Administrador del sistema
        </div>

    </div>


    <!-- ESTADÍSTICAS -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-number">25</div>
            <div class="stat-label">Usuarios registrados</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-number">120</div>
            <div class="stat-label">Productos disponibles</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📄</div>
            <div class="stat-number">18</div>
            <div class="stat-label">Rentas activas</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💳</div>
            <div class="stat-number">$12,500</div>
            <div class="stat-label">Ingresos del mes</div>
        </div>

    </div>


    <!-- MÓDULOS -->
    <h2 class="modules-title">
        Panel administrativo
    </h2>

    <div class="modules-grid">

        <!-- USUARIOS -->
        <a href="{{ route('usuarios.index') }}" class="module-card">

            <div class="module-icon">👥</div>

            <h3>Usuarios</h3>

            <p>
                Administra clientes, empleados y administradores.
            </p>

        </a>

<a href="{{ route('admin.productos.index') }}" class="module-card">

    <div class="module-icon">📦</div>

    <h3>Inventario</h3>

    <p>
        Gestiona productos, existencias y disponibilidad.
    </p>

</a>


<!-- RENTAS -->
<a href="{{ route('admin.rentas.index') }}" class="module-card">

    <div class="module-icon">📄</div>

    <h3>Rentas</h3>

    <p>
        Consulta y administra todas las rentas.
    </p>

</a>


        <!-- PAGOS -->
        <a href="#" class="module-card">

            <div class="module-icon">💳</div>

            <h3>Pagos</h3>

            <p>
                Visualiza pagos realizados y pendientes.
            </p>

        </a>


        <!-- REPORTES -->
        <a href="{{ route('reporte.usuarios') }}" target="_blank" class="module-card">

            <div class="module-icon">📊</div>

            <h3>Reportes</h3>

            <p>
                Genera reportes administrativos del sistema.
            </p>

        </a>


        <!-- GRAFICAS -->
        <a href="{{ route('admin.graficas') }}" class="module-card">

            <div class="module-icon">📈</div>

            <h3>Gráficas</h3>

            <p>
                Analiza estadísticas y métricas importantes.
            </p>

        </a>

    </div>

</div>

@endsection