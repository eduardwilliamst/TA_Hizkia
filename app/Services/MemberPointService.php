<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\MemberPoint;

class MemberPointService
{
    public function calculatePoints($userId)
    {
        $reservations = Reservation::where('user_id', $userId)->get();
        $points = 0;

        foreach ($reservations as $reservation) {
            $productType = $reservation->product->productType->name;
            $quantity = $reservation->quantity;
            $price = $reservation->product->price;

            if (in_array($productType, ['Deluxe', 'Superior', 'Suite'])) {
                $points += 5 * $quantity;
            } else {
                $points += floor(($price * $quantity) / 300000);
            }
        }

        $memberPoint = MemberPoint::firstOrNew(['user_id' => $userId]);
        $memberPoint->points = $points;
        $memberPoint->save();
    }
}
