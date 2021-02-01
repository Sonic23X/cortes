<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    const DISPLAY_ALL_USERS = 1;
    const DISPLAY_ROOT_USERS = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'amount',
        'display',
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
