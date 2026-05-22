@extends('cpanel.app')

@section('title', 'Verificación 2FA')

@section('content')

<div style="max-width:400px; margin:60px auto; background:white; padding:30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2);">

    <h2 style="text-align:center;">Verificación en 2 pasos</h2>
    <p style="text-align:center;">Ingresa el código de 6 dígitos enviado a tu correo</p>

    {{-- Mensajes de error --}}
    @if(session('error'))
        <div style="background:#fee2e2; color:#dc2626; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Mensaje de éxito (para reenvío) --}}
    @if(session('success'))
        <div style="background:#d1fae5; color:#059669; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('2fa.verificar') }}">
        @csrf

        <input 
            type="text" 
            name="codigo" 
            placeholder="Código de 6 dígitos"
            maxlength="6"
            inputmode="numeric"
            pattern="[0-9]{6}"
            autocomplete="one-time-code"
            style="width:100%; padding:12px; margin-bottom:15px; text-align:center; font-size:18px; letter-spacing:5px; border:1px solid #ccc; border-radius:5px;"
            required
        >

        <button type="submit" style="width:100%; padding:12px; background:black; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:bold;">
            Verificar
        </button>
    </form>

    {{-- Botón reenviar código --}}
    <form method="POST" action="{{ route('2fa.reenviar') }}" style="margin-top:15px;">
        @csrf
        <button type="submit" style="width:100%; padding:10px; background:transparent; color:#666; border:1px solid #ccc; border-radius:5px; cursor:pointer;">
            ¿No recibiste el código? <strong>Reenviar</strong>
        </button>
    </form>

    {{-- Advertencias --}}
    <div style="margin-top:20px; padding:15px; background:#f9fafb; border-radius:5px; font-size:13px; color:#666;">
        <p style="margin:0 0 8px 0;">⚠️ <strong>Importante:</strong></p>
        <ul style="margin:0; padding-left:20px;">
            <li>El código expira en <strong>10 minutos</strong></li>
            <li>Revisa tu carpeta de spam si no lo encuentras</li>
            <li>No compartas este código con nadie</li>
        </ul>
    </div>

    {{-- Link informativo --}}
    <p style="text-align:center; margin-top:15px; font-size:12px; color:#999;">
        ¿Por qué usamos verificación en 2 pasos? 
        <a href="[support.google.com](https://support.google.com/accounts/answer/185839)" target="_blank" rel="noopener" style="color:#3b82f6;">
            Más información
        </a>
    </p>

</div>

@endsection
