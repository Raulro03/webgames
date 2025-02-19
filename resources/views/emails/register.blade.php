<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
<div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px;">
    <h2 style="color: #333;">¡Bienvenido a {{ config('app.name') }}!</h2>
    <p>Hola, gracias por registrarte en nuestra plataforma. Esperamos que disfrutes la experiencia.</p>
    <p>Si tienes alguna duda, contáctanos.</p>
    <p style="text-align: center;">
        <a href="{{ url('/') }}" style="padding: 10px 15px; background: #6200ea; color: white; text-decoration: none; border-radius: 5px;">
            Ir a la Web
        </a>
    </p>
    <p style="font-size: 12px; color: #777;">© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
</div>
</body>
</html>
