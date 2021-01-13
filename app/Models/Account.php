<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'amount',
    ];

    public static function updateAmount($id, $balance)
    {
        $instance = new static;

        $data = [ 
            'amount' => $balance,
        ];

        $instance::where('id', $id)->update($data);
    }
}
