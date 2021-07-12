<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    const ROL_ROOT = 'root';
    const ROL_ADMIN = 'administrador';
    const ROL_COURIER = 'repartidor';
    const ROL_READER = 'lectura';

    const ACTIVE = 1;
    const NOT_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = 
    [
        'name',
        'last_name',
        'email',
        'password',
        'status',
        'terminal'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = 
    [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = 
    [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = 
    [
        'deleted_at'
    ];
}
