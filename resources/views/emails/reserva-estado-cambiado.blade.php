<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Actualización de reserva</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">

    <div style="max-width: 600px; margin: 40px auto; background: #ffffff; padding: 30px; border-radius: 10px;">

        <h1 style="margin-top: 0;">SalaEventos</h1>

        <h2>Actualización de tu reserva</h2>

        <p>
            Hola {{ $reserva->reserva->nombre_completo }},
        </p>

        @if ($reserva->estado === 'confirmada')

            <p>
                Tu reserva ha sido <strong>confirmada</strong>.
                Te esperamos en la fecha indicada.
            </p>

        @elseif ($reserva->estado === 'cancelado')

            <p>
                Tu reserva ha sido <strong>cancelada</strong>.
                Esperamos poder verte en otra ocasión.
            </p>

        @endif

        <hr>

        <h3>Datos de la reserva</h3>

        <p>
            <strong>Fecha:</strong>
            {{ $reserva->reserva->fecha_evento }}
        </p>

        <p>
            <strong>Hora de entrada:</strong>
            {{ $reserva->reserva->hora_entrada }}
        </p>

        <p>
            <strong>Hora de salida:</strong>
            {{ $reserva->reserva->hora_salida }}
        </p>

        <p>
            <strong>Estado anterior:</strong>
            {{ $estadoAnterior }}
        </p>

        <p>
            <strong>Nuevo estado:</strong>
            {{ $reserva->estado }}
        </p>

        <hr>

        <p>
            Gracias por utilizar SalaEventos.
        </p>

    </div>

</body>
</html>