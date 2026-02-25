<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Place;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'place_id',
        'status',
        'start_time',
        'end_time',
        'amount',
        'paid'
    ];

    /**
     * start_timeとend_timeの値をdatetimeにcastする
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
