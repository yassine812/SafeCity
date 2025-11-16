<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',

        'title',
        'description',

        'city',
        'address_line1',
        'postal_code',
        'country',

        'status_id',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /* RELATIONS */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function images(): HasMany
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
        return $this->votes()->where('user_id', $user->id)->exists();
    }


}
