<?php

namespace App\Services;

use App\Models\Place;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ReservationService
{
    public function reserve(int $userId, int $placeId): Place
    {
        // ユーザーが予約済みかどうかチェック
        $reservationExists = Reservation::where([
            'user_id' => $userId,
            'status' => 'reserved',
        ])->exists();

        if ($reservationExists) {
            throw new RuntimeException('すでに予約済みになります。 他で予約したい場合はキャンセルしてください。');
        }

        $place = Place::find($placeId);

        if (! $place || $place->status !== 'available') {
            throw new RuntimeException('こちらは利用できません。');
        }

        DB::transaction(function () use ($userId, $place) {
            Reservation::create([
                'user_id' => $userId,
                'place_id' => $place->id,
            ]);

            $place->update([
                'status' => 'reserved',
            ]);
        });

        // 場所の予約状況のステータスを更新
        return $place->fresh(['sector', 'reservations']);
    }

    public function cancel(int $userId, Reservation $reservation): Place
    {
        if ($reservation->user_id !== $userId) {
            throw new RuntimeException('予約が見つかりません。');
        }

        DB::transaction(function () use ($reservation) {
            $reservation->update([
                'status' => 'cancelled',
            ]);

            $reservation->place()->update([
                'status' => 'available',
            ]);
        });

        return $reservation->place()->first()->load('sector', 'reservations');
    }
}
