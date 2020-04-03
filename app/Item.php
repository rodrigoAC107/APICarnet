<?php

namespace App;

use App\License;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function licenses(){
        return $this->belongsToMany(License::class);
    }
}
