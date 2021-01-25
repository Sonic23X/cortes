<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concept;

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
        'id_courier'
    ];

    public static function paymentsToUrbo($id_courier)
    {   
        $instance = new static;

        $concept = Concept::where('heading', Concept::HEADING_TO_URBO)->select('id')->get();
        $accumulated = $instance::where('id_courier', $id_courier)->whereIn('concept', $concept )->sum('amount');

        return ( $accumulated != null) ? $accumulated : 0;
    }

    public static function paymentsToCourier($id_courier)
    {   
        $instance = new static;

        $concept = Concept::where('heading', Concept::HEADING_TO_COURIER)->select('id')->get();

        $accumulated = $instance::where('id_courier', $id_courier)->whereIn('concept', $concept )->sum('amount');

        return ( $accumulated != null) ? $accumulated : 0;
    }

    public function scopeTypeToUrbo($query)
    {
        $concept = Concept::where('heading', Concept::HEADING_TO_URBO)->select('id')->get();
        return $query->where('concept', $concept);
    }

    public function scopeTypeToCourier($query)
    {
        $concept = Concept::where('heading', Concept::HEADING_TO_COURIER)->select('id')->get();
        return $query->where('concept', $concept);
    }
}
