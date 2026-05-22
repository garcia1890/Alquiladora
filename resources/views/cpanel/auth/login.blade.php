@extends('cpanel.app') 

@section('title', 'Iniciar Sesión')

@section('content')

<style>
.login-container {
    max-width: 420px;
    margin: 60px auto;
    background: #ffffff;
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.login-title {
    text-align: center;
    font-size: 1.7em;
    font-weight: bold;
}
.login-subtitle {
    text-align: center;
    margin-bottom: 20px;
    color: #666;
}
.form-group {
    margin-bottom: 15px;
}
input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
.login-btn {
    width: 100%;
    padding: 10px;
    background: black;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
</style>

<div class="login-container">

    <h2 class="login-title">Iniciar Sesión</h2>
    <p class="login-subtitle">Accede al sistema</p>

    @if(session('error'))
        <div style="color:red; text-align:center;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf
        
        <div class="form-group">
            <label>Correo</label>
            <input type="email" name="correo" required>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="login-btn">Ingresar</button>

    </form>

</div>

@endsection
