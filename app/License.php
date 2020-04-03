<?php

namespace App;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = [
        'persona_id', 
        'date_awarded',
        'date_expiration',
    ];

    public function items(){
        return $this->belongsToMany(Item::class);
    }
}
