<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game - {{ $game->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3e8ff;
            color: #4a0072;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h1>a{
            font-size: 32px;
            font-weight: bold;
            color: #4a0072;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #6b21a8;
        }
        p {
            font-size: 16px;
            color: #4a0072;
            margin: 10px 0;
        }
        .highlight {
            font-weight: bold;
            color: #8b5cf6;
        }
        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .game-image {
            width: 250px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
<div class="container">
    <h1><a href="https://webgames.test/">WEBGAMES</a></h1>

    <h2>{{ $game->title }}</h2>

    <!-- Imagen con URL absoluta -->
    <div class="image-container">
        <img src="{{$imageData}}" width="300" alt="{{ $game->title }}">
    </div>

    <p><span class="highlight">{{__('Description')}}:</span> {{ $game->description }}</p>
    <p><span class="highlight">{{__('Rating')}}:</span> {{ $game->average_rating }}</p>
    <p><span class="highlight">{{__('Price')}}:</span> {{ number_format($game->price / 100, 2, ',', '.') }}€</p>
    <p><span class="highlight">{{__('Developer')}}:</span> {{ $game->developer->name }}</p>
    <p><span class="highlight">{{__('Category')}}:</span> {{ $game->categories->pluck('name')->join(', ') }}</p>
    <p><span class="highlight">{{__('Release date')}}:</span> {{ $game->release_date->format('d/m/Y') }}</p>
</div>
</body>
</html>
