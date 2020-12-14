<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'id_order',
        'id_courier',
        'amount',
        'id_place',
    ];


    public static function getAmountPerCourier($id_courier)
    {   
        $quantities = (new static)::where('id_courier', $id_courier)->sum('amount');

        return $quantities;
        
    }
}
