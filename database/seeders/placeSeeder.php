<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class placeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placePerSector = 10;
        $sectors = Sector::all();
        $placeData = [];

        foreach ($sectors as $sector) {
            for ($i = 1; $i <= $placePerSector; $i++) {
                $placeData[] = [
                    'sector_id' => $sector->id,
                    'place_number' => $sector->name . '-' . $i
                ];
            }
        }

        Place::insert($placeData);
    }
}
