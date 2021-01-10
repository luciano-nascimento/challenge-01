<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipItem extends Model
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

    public function shiporder()
    {
        return $this->belongsTo('App\Models\Shiporder');
    }
}
