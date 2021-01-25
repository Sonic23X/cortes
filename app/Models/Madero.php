<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Madero extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_courier',
        'amount_madero',
        'amount_repartos',
        'amount_urbo',
        'amount_repartidor',
    ];
    
}
