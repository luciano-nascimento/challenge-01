<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shiporders extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'person_id',
        'shipto_name',
        'shipto_address',
        'shipto_city',
        'shipto_country'
    ];
}
