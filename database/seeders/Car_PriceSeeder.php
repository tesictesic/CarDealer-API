<?php

namespace Database\Seeders;

use App\Models\Car_Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Car_PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car_Price::create([
            'vehicle_id' => 1,
            'price' => 47000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 2,
            'price' => 27000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 3,
            'price' => 75000.00,
            'date_of' => '2024-02-12',
        ]);
        Car_Price::create([
            'vehicle_id' => 4,
            'price' => 68000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 5,
            'price' => 100000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 6,
            'price' => 35000.00,
            'date_of' => '2024-02-12',
        ]);
        Car_Price::create([
            'vehicle_id' => 7,
            'price' => 78000.00,
            'date_of' => '2024-02-12',

        ]);

        Car_Price::create([
            'vehicle_id' => 8,
            'price' => 130000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 9,
            'price' => 200000.00,
            'date_of' => '2024-02-12',
        ]);
        Car_Price::create([
            'vehicle_id' => 10,
            'price' => 45.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 11,
            'price' => 97000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 12,
            'price' => 27000.00,
            'date_of' => '2024-02-12',
        ]);
        Car_Price::create([
            'vehicle_id' => 13,
            'price' => 40000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 14,
            'price' => 80000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 15,
            'price' => 90000.00,
            'date_of' => '2024-02-12',
        ]);
        Car_Price::create([
            'vehicle_id' => 16,
            'price' => 200000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 17,
            'price' => 74000.00,
            'date_of' => '2024-02-12',
        ]);

        Car_Price::create([
            'vehicle_id' => 18,
            'price' => 62000.00,
            'date_of' => '2024-02-12',
        ]);
    }
}
