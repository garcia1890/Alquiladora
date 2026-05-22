@extends('cpanel.app')

@section('title','Gráficas')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

    .grafica-container{
        max-width:1000px;
        margin:auto;
    }

    .card{
        background:white;
        padding:30px;
        border-radius:20px;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    }

    h2{
        margin-bottom:20px;
        color:#222;
    }

</style>

<div class="grafica-container">

    <div class="card">

        <h2>📈 Usuarios por Rol</h2>

        <canvas id="usuariosChart"></canvas>

    </div>

</div>


<script>

const ctx = document.getElementById('usuariosChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: ['Administradores', 'Clientes', 'Empleados'],

        datasets: [{

            label: 'Cantidad',

            data: [
                {{ $admins }},
                {{ $clientes }},
                {{ $empleados }}
            ],

            borderWidth: 1

        }]
    },

    options: {

        responsive: true,

        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>

@endsection