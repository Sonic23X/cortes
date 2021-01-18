<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SheetMovement extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_IN = 'ingreso';
    const TYPE_OUT = 'egreso';

    protected $fillable = [
        'id_sheet', 'details', 'date', 'type',
        'amount', 'balance'
    ];
}
