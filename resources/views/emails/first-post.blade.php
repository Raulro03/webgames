<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('First Post Created')}}</title>
</head>
<body>
<div>
    <h2>¡{{__('Congratulations')}}, {{ $post->user->name }}! 🎉</h2>
    <p>{{__('You have published your first post on our platform')}}</p>
    <h3>{{ $post->title }}</h3>
    <p>{{ Str::limit($post->body, 100) }}</p>
    <a href="{{ route('post.show', $post) }}">
        {{__('See Post')}}
    </a>
</div>
</body>
