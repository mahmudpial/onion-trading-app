<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'plan', 'plan_expires_at'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'plan_expires_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPro(): bool
    {
        return in_array($this->plan, ['pro', 'enterprise']);
    }

    public function planLabel(): string
    {
        return match ($this->plan) {
            'pro' => 'Pro',
            'enterprise' => 'Enterprise',
            default => 'Free',
        };
    }
}