@extends('cpanel.app')

@section('title', 'Recuperar Contraseña')

@section('content')

<style>

body{
    background: linear-gradient(135deg, #0f172a, #1e293b, #334155);
    min-height: 100vh;
}

/* CONTENEDOR */
.recovery-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:90vh;
    padding:20px;
}

/* CARD */
.recovery-container{
    width:100%;
    max-width:450px;
    background:rgba(255,255,255,0.08);
    backdrop-filter: blur(15px);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:25px;
    padding:40px;
    box-shadow:
        0 10px 40px rgba(0,0,0,0.35),
        inset 0 0 0 1px rgba(255,255,255,0.05);
    color:white;
    animation:fadeIn 0.8s ease;
}

/* ICONO */
.recovery-icon{
    width:95px;
    height:95px;
    margin:0 auto 20px;
    border-radius:50%;
    background:linear-gradient(135deg,#f59e0b,#f97316);
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:42px;
    box-shadow:0 5px 20px rgba(249,115,22,0.5);
}

/* TITULOS */
.recovery-title{
    text-align:center;
    font-size:2em;
    font-weight:bold;
    margin-bottom:8px;
}

.recovery-subtitle{
    text-align:center;
    color:#cbd5e1;
    margin-bottom:30px;
    line-height:1.6;
    font-size:0.95em;
}

/* ALERTAS */
.alert-error{
    background:#7f1d1d;
    color:#fecaca;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    text-align:center;
}

.alert-success{
    background:#14532d;
    color:#bbf7d0;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    text-align:center;
}

/* FORM */
.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    color:#e2e8f0;
    font-weight:500;
}

/* INPUT */
.form-control{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:rgba(255,255,255,0.12);
    color:white;
    font-size:15px;
    transition:0.3s;
    outline:none;
}

.form-control::placeholder{
    color:#cbd5e1;
}

.form-control:focus{
    background:rgba(255,255,255,0.18);
    box-shadow:0 0 0 3px rgba(249,115,22,0.35);
    transform:translateY(-2px);
}

/* BOTON */
.recovery-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#f59e0b,#f97316);
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
    box-shadow:0 5px 15px rgba(249,115,22,0.4);
}

.recovery-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 20px rgba(249,115,22,0.6);
}

/* LINK */
.back-login{
    margin-top:18px;
    text-align:center;
}

.back-login a{
    color:#fdba74;
    text-decoration:none;
    transition:0.3s;
}

.back-login a:hover{
    color:white;
    text-decoration:underline;
}

/* FOOTER */
.recovery-footer{
    text-align:center;
    margin-top:25px;
    color:#cbd5e1;
    font-size:0.85em;
}

/* ANIMACION */
@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

</style>

<div class="recovery-wrapper">

    <div class="recovery-container">

        <div class="recovery-icon">
            🔑
        </div>

        <h2 class="recovery-title">
            Recuperar Contraseña
        </h2>

        <p class="recovery-subtitle">
            Ingresa tu correo electrónico y te enviaremos
            una nueva contraseña temporal para acceder
            al sistema.
        </p>

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">

                <label>Correo electrónico</label>

                <input
                    type="email"
                    name="correo"
                    class="form-control"
                    placeholder="Ingresa tu correo"
                    required
                >

            </div>

            <button type="submit" class="recovery-btn">
                Enviar nueva contraseña
            </button>

            <div class="back-login">
                <a href="{{ route('login') }}">
                    ← Volver al inicio de sesión
                </a>
            </div>

        </form>

        <div class="recovery-footer">
            © {{ date('Y') }} Alquiladora GAOS
        </div>

    </div>

</div>

@endsection