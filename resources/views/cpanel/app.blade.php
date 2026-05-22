<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Alquiladora GAOS')</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
            min-height:100vh;
            overflow-x:hidden;
        }

        /*
        ========================================
        HEADER
        ========================================
        */

        header{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:80px;
            background:#111;
            color:white;
            z-index:1000;

            display:flex;
            align-items:center;
            justify-content:space-between;

            padding:0 25px;

            box-shadow:0 2px 10px rgba(0,0,0,.2);
        }

        .header-left{
            display:flex;
            align-items:center;
            gap:20px;
        }

        .hamburger{
            font-size:28px;
            cursor:pointer;
            user-select:none;
            transition:.3s;
        }

        .hamburger:hover{
            transform:scale(1.1);
        }

        .logo-text h1{
            font-size:24px;
        }

        .logo-text p{
            font-size:13px;
            opacity:.7;
        }

        .header-nav{
            display:flex;
            gap:15px;
        }

        .header-nav a{
            color:white;
            text-decoration:none;
            padding:10px 15px;
            border-radius:8px;
            transition:.3s;
            font-weight:bold;
        }

        .header-nav a:hover{
            background:#222;
        }

        /*
        ========================================
        SIDEBAR
        ========================================
        */

        .sidebar{
            position:fixed;
            top:0;
            left:0;

            width:260px;
            height:100%;

            background:#181818;

            z-index:1200;

            transform:translateX(-100%);
            transition:.3s ease;

            overflow-y:auto;

            box-shadow:4px 0 15px rgba(0,0,0,.3);
        }

        .sidebar.active{
            transform:translateX(0);
        }

        .sidebar-header{
            padding:30px 25px;
            border-bottom:1px solid #333;
            margin-top:80px;
        }

        .sidebar-header h2{
            color:white;
        }

        .menu{
            list-style:none;
            padding:15px 0;
        }

        .menu-title{
            color:#888;
            font-size:12px;
            text-transform:uppercase;
            padding:15px 25px 5px;
            letter-spacing:1px;
        }

        .menu-item a,
        .logout-btn{
            display:flex;
            align-items:center;
            gap:10px;

            width:100%;

            padding:15px 25px;

            color:#ddd;
            text-decoration:none;

            background:none;
            border:none;

            font-size:15px;
            cursor:pointer;

            transition:.3s;
        }

        .menu-item a:hover,
        .logout-btn:hover{
            background:#252525;
            color:white;
            padding-left:35px;
        }

        /*
        ========================================
        OVERLAY
        ========================================
        */

        .overlay{
            position:fixed;
            top:0;
            left:0;

            width:100%;
            height:100%;

            background:rgba(0,0,0,.5);

            z-index:1100;

            opacity:0;
            visibility:hidden;

            transition:.3s;
        }

        .overlay.active{
            opacity:1;
            visibility:visible;
        }

        /*
        ========================================
        CONTENT
        ========================================
        */

        .main-content{
            padding-top:110px;
            padding-left:30px;
            padding-right:30px;
            padding-bottom:30px;

            min-height:100vh;
        }

        /*
        ========================================
        FOOTER
        ========================================
        */

        footer{
            background:#111;
            color:white;
            text-align:center;
            padding:18px;
        }

        /*
        ========================================
        RESPONSIVE
        ========================================
        */

        @media(max-width:768px){

            .logo-text h1{
                font-size:20px;
            }

            .logo-text p{
                display:none;
            }

            .header-nav{
                display:none;
            }

            .main-content{
                padding-left:15px;
                padding-right:15px;
            }

        }

    </style>

    @stack('styles')

</head>
<body>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<!-- HEADER -->
<header>

    <div class="header-left">

        <!-- BOTÓN SIEMPRE VISIBLE -->
        <div class="hamburger" id="sidebarToggle">
            ☰
        </div>

        <div class="logo-text">
            <h1>Alquiladora GAOS</h1>
            <p>Sistema web de gestión de renta</p>
        </div>

    </div>

    <nav class="header-nav">
        <a href="{{ url('/') }}">Inicio</a>
    </nav>

</header>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <div class="sidebar-header">
        <h2>Menú Principal</h2>
    </div>

    <ul class="menu">

        {{-- NO LOGEADO --}}
        @if(!session()->has('usuario_id'))

            <li class="menu-item">
                <a href="{{ route('login') }}">
                    🔐 Iniciar sesión
                </a>
            </li>

            <li class="menu-item">
    <a href="{{ route('usuarios.form') }}">
        📝 Registrarse
    </a>
</li>

        @endif


        {{-- CLIENTE --}}
        @if(session('rol_id') == 2)

            <div class="menu-title">Servicios</div>

            <li class="menu-item"><a href="#">🔥 Ofertas</a></li>
            <li class="menu-item"><a href="#">🛠️ Servicios</a></li>

            <div class="menu-title">Productos</div>

            <li class="menu-item"><a href="#">🪑 Mesas</a></li>
            <li class="menu-item"><a href="#">💺 Sillas</a></li>
            <li class="menu-item"><a href="#">🏕️ Lonas</a></li>
            <li class="menu-item"><a href="#">⛺ Carpas</a></li>
            <li class="menu-item"><a href="#">🎈 Inflables</a></li>

            <li class="menu-item"><a href="#">📦 Mis rentas</a></li>

        @endif


        {{-- EMPLEADO --}}
        @if(session('rol_id') == 3)

            <div class="menu-title">Panel Empleado</div>

            <li class="menu-item"><a href="#">🚚 Entregas</a></li>
            <li class="menu-item"><a href="#">📦 Rentas activas</a></li>
            <li class="menu-item"><a href="#">👥 Clientes</a></li>

        @endif


        {{-- ADMIN --}}
        @if(session('rol_id') == 1)

            <div class="menu-title">Administración</div>

            <li class="menu-item"><a href="{{ route('usuarios.index') }}">👥 Usuarios</a></li>
            <li class="menu-item"><a href="#">🧍 Clientes</a></li>
            <li class="menu-item"><a href="#">🧑‍🔧 Empleados</a></li>

            <div class="menu-title">Inventario</div>

            <li class="menu-item">
                <a href="{{ route('admin.productos.index') }}">
                    📦 Inventario
                </a>
            </li>
            

            <div class="menu-title">Finanzas</div>

            <li class="menu-item">
    <a href="{{ route('admin.rentas.index') }}">
        📄 Rentas
    </a>
</li>
            <li class="menu-item"><a href="#">💳 Pagos</a></li>

            <div class="menu-title">Estadísticas</div>

           <li class="menu-item">
    <a href="{{ route('reporte.usuarios') }}" target="_blank">
        📊 Reportes
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('admin.graficas') }}">
        📈 Gráficas
    </a>
</li>

        @endif


        {{-- LOGOUT --}}
        @if(session()->has('usuario_id'))

            <li class="menu-item">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="logout-btn">
                        🚪 Cerrar sesión
                    </button>

                </form>

            </li>

        @endif

    </ul>

</aside>

<!-- CONTENIDO -->
<div class="main-content">

    @yield('content')

</div>

<!-- FOOTER -->
<footer>
    © Alquiladora GAOS
</footer>

<script>

    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('overlay');

    toggle.addEventListener('click', () => {

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');

    });

    overlay.addEventListener('click', () => {

        sidebar.classList.remove('active');
        overlay.classList.remove('active');

    });

</script>

@stack('scripts')

</body>
</html>