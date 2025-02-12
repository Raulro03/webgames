<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = [ 'category_type', 'related_id'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function related()
    {
        if ($this->category_type === 'game') {
            return $this->belongsTo(Game::class, 'related_id');
        } elseif ($this->category_type === 'platform') {
            return $this->belongsTo(Platform::class, 'related_id');
        } elseif ($this->category_type === 'character') {
            return $this->belongsTo(Character::class, 'related_id');
        }
        return null;
    }
}
