@extends('cpanel.app')

@section('title', 'Nueva Contraseña')

@section('content')

<div class="login-container">

    <h2 class="login-title">
        Nueva Contraseña
    </h2>

    @if(session('error'))
        <div style="color:red;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>Nueva contraseña</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirmar contraseña</label>
            <input type="password"
                   name="password_confirmation"
                   required>
        </div>

        <button type="submit" class="login-btn">
            Actualizar contraseña
        </button>

    </form>

</div>

@endsection