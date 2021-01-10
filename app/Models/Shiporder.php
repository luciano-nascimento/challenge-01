<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shiporder extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    protected $fillable = [
        'id',
        'people_id',
        'shipto_name',
        'shipto_address',
        'shipto_city',
        'shipto_country'
    ];

    public function shipItem()
    {
        return $this->hasMany('App\Models\ShipItem');
    }
}
