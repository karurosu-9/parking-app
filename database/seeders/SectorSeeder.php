<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            [
                'name' => "A",
                'description' => "Near entrance",
                'price' => "500"
            ],
            [
                'name' => "B",
                'description' => "Middle area",
                'price' => "350"
            ],
            [
                'name' => "C",
                'description' => "Far end",
                'price' => "200"
            ],
        ];

        Sector::insert($sectors);
    }
}
