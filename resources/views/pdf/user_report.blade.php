<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen del Usuario - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            border-radius: 5px;
            height: 50px;
            margin-right: 15px;
        }

        .logo h1 {
            float: left;
            font-size: 22px;
            color: #111827;
            margin-right: 10px;
        }

        h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #111827;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        p {
            font-size: 14px;
            line-height: 1.6;
            margin: 6px 0;
        }

        .highlight {
            font-weight: bold;
            color: #2563eb;
        }

        .section {
            margin-top: 30px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .chart-container {
            margin-top: 25px;
            text-align: center;
        }

        .chart-image {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 4px rgba(0,0,0,0.1);
        }

        footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<header class="header">
    <div class="logo">
        <img src="{{ public_path('images/webgames.png') }}" alt="Logo">
        <h1>WebGames</h1>
    </div>
    <div style="text-align: right; font-size: 12px; color: #6b7280;">
        <strong>Fecha:</strong><br>{{ now()->format('d/m/Y H:i') }}
    </div>
</header>
<div class="container">
    <section>
        <h2>Datos Personales</h2>
        <table class="info-table">
            <tr>
                <td class="highlight">Nombre:</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td class="highlight">Email:</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td class="highlight">Fecha de registro:</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
        </table>
    </section>

    <section class="section">
        <h2>Actividad</h2>
        <table class="info-table">
            <tr>
                <td class="highlight">Total de posts:</td>
                <td>{{ $user->posts_count }}</td>
            </tr>
            <tr>
                <td class="highlight">Total de comentarios:</td>
                <td>{{ $user->comments_count }}</td>
            </tr>
        </table>
    </section>

    <div class="page-break"></div>

    <section class="section">
        <h2>Distribucion de posts por categoria</h2>
        <div class="chart-container">
            @if($chartImage)
                <img src="{{ $chartImage }}" class="chart-image" alt="Grafico de categorias">
            @else
                <p>No se pudo cargar el grafico.</p>
            @endif
        </div>
    </section>

    <footer>
        Reporte generado automaticamente por el sistema.
    </footer>
</div>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial", "normal");
                $size = 10;
                $pageText = "Pagina $PAGE_NUM de $PAGE_COUNT";
                $x = 520;
                $y = 820;
                $pdf->text($x, $y, $pageText, $font, $size);
            ');
        }
    </script>
</body>
</html>
