<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Post Creado</title>
</head>
<body>
<div>
    <h2>¡Felicidades, {{ $post->user->name }}! 🎉</h2>
    <p>Has publicado tu primer post en nuestra plataforma.</p>
    <h3>{{ $post->title }}</h3>
    <p>{{ Str::limit($post->body, 100) }}</p>
    <a href="{{ route('post.show', $post) }}">
        Ver Post
    </a>
</div>
</body>
