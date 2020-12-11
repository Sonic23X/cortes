<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concept extends Model
{
    use HasFactory, SoftDeletes;

    const HEADING_TO_COURIER = 1;
    const HEADING_TO_URBO = 2;
    const HEADING_OTHER = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'concept',
        'heading',
    ];
}
