<?php

namespace Database\Seeders;

use App\Models\Car_Body;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Car_BodySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car_Body::create([
            "name"=>"Sedan"
        ]);
        Car_Body::create([
            "name"=>"Estate Car"
        ]);
        Car_Body::create([
            "name"=>"SUV"
        ]);
        Car_Body::create([
        "name"=>"Coupe"
    ]);
    }
}
