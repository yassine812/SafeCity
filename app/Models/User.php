<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Incident;
use App\Models\Comment;
use App\Models\Vote;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'provider',
        'provider_id',
        'provider_name',
        'email_verified_at'
    ];
    
    protected $attributes = [
        'role' => 'citizen',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        // Removed 'password' => 'hashed' to prevent double hashing
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class, 'citizen_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'citizen_id');
    }
    
    public function votes()
    {
        return $this->hasMany(Vote::class, 'citizen_id');
    }
    
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    
    /**
     * Set the user's password with automatic hashing.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
