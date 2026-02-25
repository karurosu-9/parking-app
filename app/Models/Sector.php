<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Place;

class Sector extends Model
{
    protected $fillable = ['name', 'description', 'price'];

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
