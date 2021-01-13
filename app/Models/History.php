<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'id_courier',
        'amount',
    ];

    public static function historyPerCourier($id_courier)
    {   
        $instance = new static;

        $accumulated = $instance::where('id_courier', $id_courier)->sum('amount');

        return $accumulated;
    }
    
}

