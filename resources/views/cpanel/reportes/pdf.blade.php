<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte de Usuarios</title>

    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            padding:20px;
            color:#222;
        }

        h2{
            text-align:center;
            margin-bottom:25px;
            color:#111;
        }

        .fecha{
            text-align:right;
            margin-bottom:15px;
            font-size:13px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#111;
            color:white;
            padding:12px;
            border:1px solid #000;
            font-size:14px;
        }

        td{
            border:1px solid #ccc;
            padding:10px;
            font-size:13px;
        }

        tr:nth-child(even){
            background:#f5f5f5;
        }

        .rol{
            font-weight:bold;
        }

    </style>

</head>

<body>

    <h2>Reporte General de Usuarios</h2>

    <div class="fecha">
        Fecha:
        {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Rol</th>

            </tr>

        </thead>

        <tbody>

            @foreach($usuarios as $usuario)

            <tr>

                <td>
                    {{ $usuario->id }}
                </td>

                <td>
                    {{ $usuario->nombre }}
                    {{ $usuario->apellido_pa }}
                    {{ $usuario->apellido_ma }}
                </td>

                <td>
                    {{ $usuario->correo }}
                </td>

                <td>
                    {{ $usuario->telefono }}
                </td>

                <td class="rol">

                    @if($usuario->rol_id == 1)

                        Administrador

                    @elseif($usuario->rol_id == 2)

                        Cliente

                    @elseif($usuario->rol_id == 3)

                        Empleado

                    @else

                        Sin rol

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>