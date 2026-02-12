<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessType;

class BusinessTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            'Hotel',
            'Cabaña',
            'Hostal',
            'Restaurante',
            'Cafetería',
            'Otro',
        ];

        foreach ($types as $name) {
            BusinessType::firstOrCreate(['name' => $name]);
        }
    }
}
