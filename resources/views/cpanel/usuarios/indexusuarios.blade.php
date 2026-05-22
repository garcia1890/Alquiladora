@extends('cpanel.app')

@section('title','Usuarios')

@section('content')

<style>

    .usuarios-container{
        max-width: 1400px;
        margin: auto;
    }

    .usuarios-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:25px;
        flex-wrap:wrap;
        gap:15px;
    }

    .usuarios-header h2{
        font-size:32px;
        color:#222;
    }

    .btn{
        padding:10px 18px;
        border:none;
        border-radius:10px;
        text-decoration:none;
        cursor:pointer;
        font-weight:bold;
        transition:.3s;
        display:inline-block;
    }

    .btn-success{
        background:#198754;
        color:white;
    }

    .btn-success:hover{
        background:#157347;
    }

    .btn-danger{
        background:#dc3545;
        color:white;
    }

    .btn-danger:hover{
        background:#bb2d3b;
    }

    .btn-primary{
        background:#0d6efd;
        color:white;
    }

    .btn-primary:hover{
        background:#0b5ed7;
    }

    .alert-success{
        background:#d1e7dd;
        color:#0f5132;
        padding:15px;
        border-radius:12px;
        margin-bottom:20px;
    }

    .table-container{
        background:white;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 5px 20px rgba(0,0,0,.08);
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    thead{
        background:#111;
        color:white;
    }

    th{
        padding:18px;
        text-align:left;
        font-size:15px;
    }

    td{
        padding:16px;
        border-bottom:1px solid #eee;
    }

    tbody tr:hover{
        background:#f8f9fa;
    }

    .acciones{
        display:flex;
        gap:10px;
    }

    .btn-edit{
        background:#0d6efd;
        color:white;
        padding:8px 14px;
        border-radius:8px;
        text-decoration:none;
        font-size:14px;
    }

    .btn-delete{
        background:#dc3545;
        color:white;
        padding:8px 14px;
        border:none;
        border-radius:8px;
        cursor:pointer;
        font-size:14px;
    }

    .badge{
        padding:6px 12px;
        border-radius:50px;
        font-size:13px;
        color:white;
        font-weight:bold;
    }

    .admin{
        background:#111;
    }

    .cliente{
        background:#198754;
    }

    .empleado{
        background:#0d6efd;
    }

    .top-actions{
        margin-bottom:20px;
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

</style>


<div class="usuarios-header">

    <div>

        <a href="{{ route('admin.dashboard') }}"
           class="btn btn-secondary"
           style="margin-bottom:10px; display:inline-block;">

            ← Volver

        </a>

        <h2>👥 Gestión de Usuarios</h2>

    </div>

    <a href="{{ route('usuarios.create') }}" class="btn btn-success">
        + Agregar Usuario
    </a>

</div>


    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- FORM ELIMINAR --}}
    <form id="deleteSelectedForm"
          action="{{ route('usuarios.deleteSelected') }}"
          method="POST">

        @csrf
        @method('DELETE')

        <div id="hiddenInputs"></div>

        <div class="top-actions">

            <button type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('¿Eliminar usuarios seleccionados?')">

                Eliminar Seleccionados

            </button>


            <a href="{{ URL('admon/reportes/pdf') }}"
               target="_blank"
               class="btn btn-primary">

                Generar reporte

            </a>

        </div>

    </form>


    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>✔️</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido P.</th>
                    <th>Apellido M.</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                @forelse($usuarios as $usuario)

                <tr>

                    <td>
                        <input type="checkbox"
                               class="userCheckbox"
                               value="{{ $usuario->id }}">
                    </td>

                    <td>{{ $usuario->id }}</td>

                    <td>{{ $usuario->nombre }}</td>

                    <td>{{ $usuario->apellido_pa }}</td>

                    <td>{{ $usuario->apellido_ma }}</td>

                    <td>{{ $usuario->correo }}</td>

                    <td>{{ $usuario->telefono }}</td>

                    <td>

                        @if($usuario->rol_id == 1)

                            <span class="badge admin">
                                Administrador
                            </span>

                        @elseif($usuario->rol_id == 2)

                            <span class="badge cliente">
                                Cliente
                            </span>

                        @elseif($usuario->rol_id == 3)

                            <span class="badge empleado">
                                Empleado
                            </span>

                        @else

                            <span class="badge">
                                Sin rol
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="acciones">

                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                               class="btn-edit">

                                Editar

                            </a>


                            <form action="{{ route('usuarios.destroy', $usuario->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn-delete"
                                        onclick="return confirm('¿Deseas eliminar este usuario?')">

                                    Eliminar

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="9" style="text-align:center; padding:30px;">

                        No hay usuarios registrados

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<script>

document.getElementById('deleteSelectedForm').onsubmit = function() {

    let seleccionados = [];

    document.querySelectorAll('.userCheckbox:checked').forEach(cb => {
        seleccionados.push(cb.value);
    });

    if (seleccionados.length === 0) {

        alert("No has seleccionado ningún usuario.");
        return false;
    }

    let contenedor = document.getElementById('hiddenInputs');

    contenedor.innerHTML = "";

    seleccionados.forEach(id => {

        let input = document.createElement("input");

        input.type = "hidden";
        input.name = "ids[]";
        input.value = id;

        contenedor.appendChild(input);

    });

    return true;
};

</script>

@endsection