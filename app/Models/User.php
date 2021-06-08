<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;


    static $defaultUsers = [
        ['name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'demo',
            'role' => Role::ROLE_SUPER_ADMIN,]
    ];


    protected $fillable = [
        'name',
        'email',
        'password',
        'score',
        'flag'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function subscribes()
    {
       return $this->hasMany(Subscribe::class);
    }
}
