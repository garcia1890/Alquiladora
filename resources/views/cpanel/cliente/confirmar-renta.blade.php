@extends('cpanel.app')

@section('title', 'Confirmar Renta')

@section('content')

<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>

    body{
        background:#f4f6f9;
        font-family:Arial, Helvetica, sans-serif;
    }

    .confirmar-container{
        width:100%;
    }

    .top-bar{
        display:flex;
        justify-content:flex-end;
        margin-bottom:15px;
    }

    .btn-close{
        width:42px;
        height:42px;
        background:#111;
        color:white;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        text-decoration:none;
        font-size:20px;
        font-weight:bold;
        transition:.3s;
        box-shadow:0 5px 15px rgba(0,0,0,.15);
    }

    .btn-close:hover{
        background:#333;
        transform:scale(1.05);
    }

    .title{
        font-size:35px;
        margin-bottom:30px;
        color:#111;
    }

    .card-box{
        background:white;
        padding:30px;
        border-radius:25px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
        margin-bottom:25px;
    }

    .card-box h2{
        margin-bottom:20px;
        color:#111;
    }

    .info-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
        gap:20px;
    }

    .input-group{
        display:flex;
        flex-direction:column;
    }

    .input-group label{
        margin-bottom:10px;
        font-weight:bold;
        color:#333;
    }

    .input-group input,
    .input-group textarea{
        padding:15px;
        border:1px solid #ddd;
        border-radius:12px;
        outline:none;
        font-size:15px;
        transition:.3s;
    }

    .input-group input:focus,
    .input-group textarea:focus{
        border-color:#111;
    }

    textarea{
        resize:none;
        min-height:120px;
    }

    #map{
        width:100%;
        height:500px;
        border-radius:20px;
        overflow:hidden;
        margin-top:20px;
        border:3px solid #111;
    }

    .coords{
        margin-top:20px;
        background:#f8f9fa;
        padding:20px;
        border-radius:15px;
        border:1px solid #eee;
    }

    .coords p{
        margin:8px 0;
        color:#333;
        font-weight:bold;
    }

    .btn-confirmar{
        width:100%;
        padding:18px;
        border:none;
        background:#111;
        color:white;
        border-radius:15px;
        font-size:18px;
        cursor:pointer;
        transition:.3s;
        margin-top:25px;
    }

    .btn-confirmar:hover{
        background:#333;
        transform:translateY(-2px);
    }

    .resumen-table{
        width:100%;
        border-collapse:collapse;
    }

    .resumen-table thead{
        background:#111;
        color:white;
    }

    .resumen-table th,
    .resumen-table td{
        padding:15px;
        text-align:center;
        border-bottom:1px solid #eee;
    }

    .total{
        margin-top:20px;
        text-align:right;
        font-size:28px;
        font-weight:bold;
        color:#111;
    }

    /*
    |--------------------------------------------------------------------------
    | RESULTADOS
    |--------------------------------------------------------------------------
    */

    #resultados{

        background:white;

        border-radius:12px;

        margin-top:8px;

        overflow:hidden;

        border:1px solid #ddd;

        box-shadow:0 5px 15px rgba(0,0,0,.08);

        max-height:300px;

        overflow-y:auto;

    }

    .resultado-item{

        padding:14px;

        cursor:pointer;

        border-bottom:1px solid #eee;

        transition:.3s;

        font-size:14px;

    }

    .resultado-item:hover{

        background:#f1f1f1;

    }

    .fecha-info{

        margin-top:10px;

        color:#666;

        font-size:14px;

    }

</style>

@php

    $hoy = date('Y-m-d');

    $maximo = date(
        'Y-m-d',
        strtotime('+8 days')
    );

@endphp

<div class="confirmar-container">

    {{-- REGRESAR --}}
    <div class="top-bar">

        <a href="{{ route('cliente.carrito') }}"
           class="btn-close">

            ✕

        </a>

    </div>


    <h1 class="title">

        Confirmar Renta 📍

    </h1>


    {{-- RESUMEN --}}
    <div class="card-box">

        <h2>
            Resumen de tu renta
        </h2>

        <table class="resumen-table">

            <thead>

                <tr>

                    <th>Producto</th>

                    <th>Precio</th>

                    <th>Cantidad</th>

                    <th>Subtotal</th>

                </tr>

            </thead>

            <tbody>

                @foreach($carrito as $item)

                    <tr>

                        <td>
                            {{ $item->nombre }}
                        </td>

                        <td>
                            ${{ number_format($item->precio, 2) }}
                        </td>

                        <td>
                            {{ $item->cantidad }}
                        </td>

                        <td>
                            ${{ number_format($item->subtotal, 2) }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <div class="total">

            Total:
            ${{ number_format($total, 2) }}

        </div>

    </div>


    {{-- FORMULARIO --}}
    <form action="{{ route('cliente.guardar.renta') }}"
          method="POST">

        @csrf

        <div class="card-box">

            <h2>
                Información del evento
            </h2>

            <div class="info-grid">

                {{-- FECHA INICIO --}}
                <div class="input-group">

                    <label>
                        Fecha inicio
                    </label>

                    <input type="date"
                           name="fecha_inicio"
                           id="fecha_inicio"
                           min="{{ $hoy }}"
                           max="{{ $maximo }}"
                           required>

                    <small class="fecha-info">

                        Solo puedes rentar
                        hasta 8 días adelante.

                    </small>

                </div>


                {{-- FECHA FIN --}}
                <div class="input-group">

                    <label>
                        Fecha fin
                    </label>

                    <input type="date"
                           name="fecha_fin"
                           id="fecha_fin"
                           min="{{ $hoy }}"
                           max="{{ $maximo }}"
                           required>

                </div>

            </div>


            {{-- BUSCADOR --}}
            <div class="input-group"
                 style="margin-top:20px;">

                <label>
                    Buscar ubicación
                </label>

                <input type="text"
                       id="busqueda"
                       placeholder="Ejemplo: Cholula, San Martín, Huejotzingo">

                <div id="resultados"></div>

            </div>


            {{-- DIRECCIÓN --}}
            <div class="input-group"
                 style="margin-top:20px;">

                <label>
                    Dirección del evento
                </label>

                <textarea name="direccion"
                          id="direccion"
                          placeholder="Selecciona una ubicación o edita manualmente"
                          required></textarea>

                <small style="margin-top:10px;color:#666;">

                    Puedes editar manualmente
                    número exterior,
                    referencias o detalles.

                </small>

            </div>


            {{-- INPUTS OCULTOS --}}
            <input type="hidden"
                   name="latitud"
                   id="latitud">

            <input type="hidden"
                   name="longitud"
                   id="longitud">


            {{-- MAPA --}}
            <div id="map"></div>


            {{-- COORDENADAS --}}
            <div class="coords">

                <p>

                    Latitud:

                    <span id="latitud-text">

                        Sin seleccionar

                    </span>

                </p>

                <p>

                    Longitud:

                    <span id="longitud-text">

                        Sin seleccionar

                    </span>

                </p>

            </div>


            {{-- BOTÓN --}}
            <button type="submit"
                    class="btn-confirmar">

                Confirmar Renta

            </button>

        </div>

    </form>

</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

    /*
    |--------------------------------------------------------------------------
    | MAPA
    |--------------------------------------------------------------------------
    */

    const map = L.map('map').setView(
        [19.0414, -98.2063],
        10
    );


    /*
    |--------------------------------------------------------------------------
    | TILES
    |--------------------------------------------------------------------------
    */

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom:22,
            attribution:'&copy; OpenStreetMap'
        }
    ).addTo(map);


    /*
    |--------------------------------------------------------------------------
    | MARCADOR
    |--------------------------------------------------------------------------
    */

    let marker;


    /*
    |--------------------------------------------------------------------------
    | FUNCIÓN MARCADOR
    |--------------------------------------------------------------------------
    */

    function colocarMarcador(lat, lng)
    {

        if(marker)
        {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng]).addTo(map);

        document.getElementById('latitud').value =
            lat;

        document.getElementById('longitud').value =
            lng;

        document.getElementById('latitud-text').innerText =
            parseFloat(lat).toFixed(6);

        document.getElementById('longitud-text').innerText =
            parseFloat(lng).toFixed(6);

    }


    /*
    |--------------------------------------------------------------------------
    | CLICK MAPA
    |--------------------------------------------------------------------------
    */

    map.on('click', async function(e)
    {

        const lat = e.latlng.lat;

        const lng = e.latlng.lng;

        colocarMarcador(lat, lng);


        try
        {

            const response = await fetch(

                `https://photon.komoot.io/reverse?lat=${lat}&lon=${lng}`

            );

            const data = await response.json();


            if(data.features.length)
            {

                const props =
                    data.features[0].properties;

                const direccion = `

${props.name || ''}
${props.street || ''}
${props.city || ''}
${props.state || ''}

                `;

                document.getElementById(
                    'direccion'
                ).value = direccion;

            }

        }
        catch(error)
        {

            console.log(error);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | BUSCADOR
    |--------------------------------------------------------------------------
    */

    const buscador =
        document.getElementById('busqueda');

    const resultados =
        document.getElementById('resultados');


    buscador.addEventListener(

        'input',

        async function()
        {

            const query = this.value;


            if(query.length < 2)
            {

                resultados.innerHTML = '';

                return;

            }


            try
            {

                const response = await fetch(

                    `https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=10`

                );


                const data = await response.json();


                resultados.innerHTML = '';


                if(!data.features.length)
                {

                    resultados.innerHTML = `

                        <div class="resultado-item">

                            No se encontraron resultados 😢

                        </div>

                    `;

                    return;

                }


                data.features.forEach(lugar =>
                {

                    const props =
                        lugar.properties;

                    const coords =
                        lugar.geometry.coordinates;


                    const texto = `

${props.name || ''}
${props.street || ''}
${props.city || ''}
${props.state || ''}

                    `;


                    const div =
                        document.createElement('div');

                    div.classList.add(
                        'resultado-item'
                    );

                    div.innerText =
                        texto;


                    div.onclick = function()
                    {

                        const lon =
                            coords[0];

                        const lat =
                            coords[1];


                        /*
                        |--------------------------------------------------------------------------
                        | MOVER MAPA
                        |--------------------------------------------------------------------------
                        */

                        map.setView(
                            [lat, lon],
                            19
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | MARCADOR
                        |--------------------------------------------------------------------------
                        */

                        colocarMarcador(
                            lat,
                            lon
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | DIRECCIÓN
                        |--------------------------------------------------------------------------
                        */

                        document.getElementById(
                            'direccion'
                        ).value = texto;


                        /*
                        |--------------------------------------------------------------------------
                        | LIMPIAR
                        |--------------------------------------------------------------------------
                        */

                        resultados.innerHTML = '';

                        buscador.value =
                            texto;

                    };


                    resultados.appendChild(div);

                });

            }
            catch(error)
            {

                console.log(error);

            }

        }

    );


    /*
    |--------------------------------------------------------------------------
    | VALIDAR FECHAS
    |--------------------------------------------------------------------------
    */

    const fechaInicio =
        document.getElementById(
            'fecha_inicio'
        );

    const fechaFin =
        document.getElementById(
            'fecha_fin'
        );


    fechaInicio.addEventListener(

        'change',

        function()
        {

            fechaFin.min =
                this.value;

        }

    );

</script>

@endsection