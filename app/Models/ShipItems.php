<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipItems extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'shiporder_id',
        'title',
        'note',
        'quantity',
        'price'
    ];
}
