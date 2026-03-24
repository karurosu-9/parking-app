<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function store(Request $request):JsonResponse
    {
        // ユーザーが予約済みかどうかチェック
        $reservationExists = Reservation::where([
            'user_id' => 1,
            'status' => 'reserved',
        ])->exists();

        if($reservationExists) {
            return response()->json([
                'error' => 'すでに予約済みになります。 他で予約したい場合はキャンセルしてください。'
            ]);
        }

        $place = Place::find($request->place_id);

        if(!$place || $place->status !== 'available') {
            return response()->json([
                'error' => 'こちらは利用できません。',
            ]);
        }

        DB::transaction(function() use ($place, $request) {
            $reservation = Reservation::create([
                'user_id' => 1,
                'place_id' => $place->id,
                'status' => 'reserved'
            ]);

            $reservation->place()->update([
                'status' => 'reserved',
            ]);
        });

        // 場所の予約状況のステータスを更新
        $place->refresh();

        return response()->json([
            'place' => PlaceResource::make($place->load('sector', 'reservations')),
            'message' => '予約しました。'
        ]);

    }
}
