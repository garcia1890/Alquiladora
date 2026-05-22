@extends('cpanel.app')

@section('title', 'Inicio - Alquiladora GAOS')

@push('styles')
<style>
/* HERO */
.hero {
    width: 100%;
    height: 75vh;
    background: url('https://images.unsplash.com/photo-1598300053653-1e7d3a9b8b87') center/cover no-repeat;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.55);
}

.hero-content {
    position: relative;
    text-align: center;
    color: white;
    max-width: 800px;
}

.hero-content h1 {
    font-size: 3em;
    margin-bottom: 15px;
}

.hero-content p {
    font-size: 1.2em;
    margin-bottom: 25px;
    opacity: 0.9;
}

.hero-buttons a {
    text-decoration: none;
    padding: 14px 25px;
    border-radius: 8px;
    font-weight: bold;
    margin: 5px;
    display: inline-block;
    transition: .3s;
}

.btn-primary {
    background: #00bcd4;
    color: white;
}

.btn-primary:hover {
    background: #0097a7;
}

.btn-secondary {
    background: #9c27b0;
    color: white;
}

.btn-secondary:hover {
    background: #7b1fa2;
}

/* BARRA INFERIOR */
.info-bar {
    background: #f4c542;
    padding: 12px;
    text-align: center;
    font-weight: bold;
    color: #333;
}

/* SERVICIOS */
.services {
    padding: 50px 30px;
    text-align: center;
}

.services h2 {
    margin-bottom: 30px;
    font-size: 2em;
}

.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: .3s;
}

.card:hover {
    transform: translateY(-5px);
}

.card h3 {
    margin-bottom: 10px;
}

</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <h1>Renta de mobiliario para eventos</h1>
        <p>Lonas, carpas, mesas, sillas e inflables para todo tipo de eventos</p>

        <div class="hero-buttons">
          
            <a href="#" class="btn-secondary">Contacto 2483637478</a>
        </div>
    </div>
</section>

<!-- BARRA -->
<div class="info-bar">
    🚚 Envíos en Puebla y alrededores | Calidad garantizada | Mejores precios
</div>

<!-- SERVICIOS -->
<section class="services">
    <h2>Nuestros Servicios</h2>

    <div class="cards">

        <div class="card">
            <h3>🎪 Carpas</h3>
            <p>Carpas para eventos grandes y pequeños.</p>
        </div>

        <div class="card">
            <h3>🪑 Sillas</h3>
            <p>Sillas cómodas y resistentes para cualquier ocasión.</p>
        </div>

        <div class="card">
            <h3>🍽️ Mesas</h3>
            <p>Mesas plegables ideales para eventos.</p>
        </div>

        <div class="card">
            <h3>🎈 Inflables</h3>
            <p>Juegos inflables para fiestas infantiles.</p>
        </div>

    </div>
</section>

@endsection
