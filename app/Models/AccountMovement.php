<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountMovement extends Model
{

    const CONCEPT_PAYMENT_TO_COURIER = 1;
    const CONCEPT_PAYMENT_TO_URBO = 2;
    const CONCEPT_OTHER = 3;

    const TYPE_CHARGE = 'cargo';
    const TYPE_PAYMENT = 'abono';

    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'concept',
        'details',
        'id_account',
        'date',
        'type',
        'amount',
        'balance',
    ];
}
