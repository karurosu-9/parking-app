<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use App\Models\Reservation;
use App\Services\ReservationService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function __construct(
        private ReservationService $reservationService
    ) {}

    public function store(Request $request):JsonResponse
    {
        try {
            $place = $this->reservationService->reserve(
                userId: 1,
                placeId: $request->place_id
            );

            return response()->json([
                'place' => PlaceResource::make($place),
                'message' => '予約しました。',
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }


    public function cancel(Request $request, Reservation $reservation):JsonResponse
    {
        try {
            $place = $this->reservationService->cancel(
                userId: 1,
                reservation: $reservation
            );

            return response()->json([
                'place' => PlaceResource::make($place),
                'message' => '予約をキャンセルしました。',
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}
