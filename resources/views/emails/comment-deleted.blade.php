<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Comment Deleted') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 2rem;">
<div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="color: #d32f2f; text-align: center;">⚠️ {{ __('Hello') }}, {{ $comment->user->name }}</h2>
    <p style="text-align: center; font-size: 1.1rem; color: #333;">
        {{ __('Your comment has been removed by a moderator.') }}
    </p>

    <hr style="margin: 1.5rem 0;">

    <h3 style="color: #d32f2f;">💬 {{ __('Comment Deleted') }}</h3>
    <blockquote style="background-color: #f9f9f9; padding: 1rem; border-left: 4px solid #d32f2f; color: #555;">
        {{ $comment->body }}
    </blockquote>

    <p style="margin-top: 1.5rem; color: #777; font-size: 0.9rem;">
        {{ __('If you believe this was a mistake, please contact support.') }}
    </p>
</div>
</body>
