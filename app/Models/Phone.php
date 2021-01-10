<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at',
        'id',
        'people_id'
    ];

    protected $fillable = [
        'number',
        'people_id'
    ];

    public function people()
    {
        return $this->belongsTo('App\Models\People');
    }
}
