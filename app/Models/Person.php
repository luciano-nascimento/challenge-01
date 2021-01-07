<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'person_id',
        'name',
    ];
}
