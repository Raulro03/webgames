<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{__('Top 5 Characters with the Best Stats')}}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            background: #fff;
            margin: 0;
            padding: 0;
            font-size: 13px;
        }
        .page {
            padding: 30px;
        }

        .page-break {
            page-break-after: always;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            border-radius: 5px;
            height: 45px;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 18px;
            color: #111827;
            margin: 0;
        }

        .character-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .character-header h2 {
            font-size: 18px;
            margin: 0 0 10px;
        }

        .character-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            margin: 0 auto 10px;
        }

        .info {
            margin-bottom: 15px;
            text-align: center;
        }

        .info strong {
            color: #111827;
        }

        .centered {
            margin-left: auto;
            margin-right: auto;
        }

        .stats, .games {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .stats th, .stats td, .games th, .games td {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            font-size: 12px;
        }

        .stats th, .games th {
            background-color: #2563eb;
            color: white;
            text-align: left;
        }

        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
@foreach($topCharacters as $loopIndex => $character)
    @php
        $stats = $character->statistics;
        $total = $stats->constitution + $stats->strength + $stats->agility + $stats->intelligence + $stats->charisma;
        $ranking = $loop->iteration;
    @endphp

    <div class="page">
        <header class="header">
            <div class="logo">
                <img src="{{ public_path('images/webgames.png') }}" alt="Logo">
                <h1>WebGames</h1>
            </div>
            <div style="text-align: right; font-size: 11px; color: #6b7280;">
                <strong>{{__('Date')}}:</strong><br>{{ now()->format('d/m/Y H:i') }}
            </div>
        </header>

        <div class="character-header">
            <h2>Top {{ $ranking }}: {{ $character->name }}</h2>
            @if($character->image_url)
                <img src="{{ public_path('storage/' . $character->image_url) }}" class="character-image" alt="{{ $character->name }}">
            @endif
        </div>

        <div class="info">
            <p><strong>{{__('Age')}}:</strong> {{ $character->age ?? 'Desconocida' }}</p>
            <p><strong>{{__('Total Score')}}:</strong> {{ $total }}</p>
        </div>

        <table class="stats centered">
            <thead>
            <tr>
                <th>{{__('Constitution')}}</th>
                <th>{{__('Strength')}}</th>
                <th>{{__('Agility')}}</th>
                <th>{{__('Intelligence')}}</th>
                <th>{{__('Charisma')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $stats->constitution }}</td>
                <td>{{ $stats->strength }}</td>
                <td>{{ $stats->agility }}</td>
                <td>{{ $stats->intelligence }}</td>
                <td>{{ $stats->charisma }}</td>
            </tr>
            </tbody>
        </table>

        <h3 style="text-align: center; font-size: 14px; margin-bottom: 5px;">{{__('games in which it appears')}}</h3>
        <table class="games centered">
            <thead>
            <tr>
                <th>{{__('Game')}}</th>
                <th>{{__('Appearance Date')}}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($character->games as $game)
                <tr>
                    <td>{{ $game->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($game->pivot->appearance)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">{{__('It doesnt appear in any game.')}}</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <footer>
            {{__('Report automatically generated by the system.')}}
        </footer>
    </div>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

<script type="text/php">
    if (isset($pdf)) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial", "normal");
            $size = 10;
            $pageText = "Página $PAGE_NUM de $PAGE_COUNT";
            $x = 520;
            $y = 820;
            $pdf->text($x, $y, $pageText, $font, $size);
        ');
    }
</script>
</body>
</html>
