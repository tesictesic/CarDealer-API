<?php

namespace Database\Seeders;

use App\Models\Service_Pack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicePackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service_Pack::create([
            "name"=>"Major Service",
        ]);Service_Pack::create([
            "name"=>"Minor Service",
        ]);
    }
}
