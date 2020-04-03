<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = "people";

    protected $fillable = [
        'person_object', 
        'dni',
        'name',
        'lastname',
        'blood_type',
        'address',
        'business',
        'phone',
        'email',
        'image',
    ];
}
