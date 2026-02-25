<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Sector;
use app\Models\Reservation;


class Place extends Model
{
    protected $fillable = ['sector_id', 'place_number', 'status'];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
