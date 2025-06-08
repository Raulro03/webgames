<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Post Deleted') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 2rem;">
<div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="color: #d32f2f; text-align: center;">⚠️ {{ __('Hello') }}, {{ $post->user->name }}</h2>
    <p style="text-align: center; font-size: 1.1rem; color: #333;">
        {{ __('We regret to inform you that your post has been deleted by a moderator.') }}
    </p>

    <hr style="margin: 1.5rem 0;">

    <h3 style="color: #d32f2f;">🗑️ {{ $post->title }}</h3>
    <p style="color: #555;">{{ Str::limit($post->body, 100) }}</p>

    <p style="margin-top: 1.5rem; color: #777; font-size: 0.9rem;">
        {{ __('If you believe this was a mistake, please contact support.') }}
    </p>
</div>
</body>
