<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('First Post Created') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 2rem;">
<div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="color: #2e7d32; text-align: center;">🎉 {{ __('Congratulations') }}, {{ $post->user->name }}!</h2>
    <p style="text-align: center; font-size: 1.1rem; color: #333;">{{ __('You have published your first post on our platform') }}</p>

    <hr style="margin: 1.5rem 0;">

    <h3 style="color: #1976d2;">📝 {{ $post->title }}</h3>
    <p style="color: #555;">{{ Str::limit($post->body, 100) }}</p>

    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('post.show', $post) }}" style="background-color: #1976d2; color: #ffffff; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 5px; font-weight: bold;">
            {{ __('See Post') }}
        </a>
    </div>
</div>
</body>
