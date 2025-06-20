<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['user_id', 'title', 'body', 'published_at' ,'status','category_id'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function forum_category(): BelongsTo
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('created_at', 'asc');
    }

    public function scopeOrderByPublished(Builder $query): void
    {
        $query->orderBy('published_at', 'desc');
    }

    public function scopeNotPublished($query)
    {
        return $query->where('published_at', '>', now());
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
            ->where('published_at', '>', now()->subYear());
    }

    public function scopeArchived($query)
    {
        return $query->where('published_at', '<=', now()->subYear());
    }
}
