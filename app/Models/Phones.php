<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phones extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'number',
        'person_id'
    ];
}
