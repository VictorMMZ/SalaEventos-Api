<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reserva recibida</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">

    <div style="max-width: 600px; margin: 40px auto; background: #ffffff; padding: 30px; border-radius: 10px;">

        <h1 style="margin-top: 0;">SalaEventos</h1>

        <h2>Solicitud de reserva recibida</h2>

        <p>
            Hola {{ $reserva->reserva->nombre_completo }},
        </p>

        <p>
            Hemos recibido correctamente tu solicitud de reserva.
            En breve nos pondremos en contacto contigo para confirmar los detalles de tu reserva.
        </p>

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
            <strong>Precio:</strong>
            {{ $reserva->total }}€
        </p>

        <p>
            <strong>Estado:</strong> Pendiente
        </p>

        <hr>

        <p>
            Gracias por confiar en SalaEventos.
        </p>

    </div>

</body>
</html>