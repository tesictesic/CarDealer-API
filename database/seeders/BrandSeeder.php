<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $audi = Brand::create(['name' => 'Audi']);
        $bmw = Brand::create(['name' => 'BMW']);
        $audi->children()->createMany([
            ['name' => 'A4'],
            ['name' => 'A5'],
            ['name' => 'A6'],
            ['name' => 'A7'],
        ]);
        $bmw->children()->createMany([
            ['name' => 'Series 3'],
            ['name' => 'M3'],
            ['name' => 'Series 5'],
            ['name' => 'Series 7'],
            ['name' => 'X1'],
            ['name' => 'X2'],
            ['name' => 'X6'],
            ['name' => 'iX'],
        ]);
    }
}
