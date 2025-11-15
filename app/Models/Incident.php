<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category_id',
        'location',
        'latitude',
        'longitude',
        'status_id',
        'votes_count'
    ];

    protected $attributes = [
        'status' => 'received',
        'votes_count' => 0,
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
    public function images()
    {
        return $this->hasMany(IncidentImage::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function hasVotedBy(User $user): bool
    {
        return $this->votes()->where('citizen_id', $user->id)->exists();
    }
}
