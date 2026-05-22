@extends('cpanel.app')

@section('title', 'Verificación 2FA')

@section('content')

<div class="container" style="max-width:500px; margin:50px auto;">
    
    <div class="card shadow p-4">
        
        <h3 class="text-center mb-3">🔐 Verificación en 2 pasos</h3>

        <p class="text-center text-muted">
            Ingresa el código que enviamos a tu correo
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verificar') }}">
            @csrf

            <div class="mb-3">
                <input 
                    type="text" 
                    name="codigo" 
                    class="form-control text-center"
                    placeholder="Ej: 123456"
                    required
                >
            </div>

            <div class="d-grid">
                <button class="btn btn-primary">
                    Verificar código
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
