<?php

namespace Database\Seeders;

use App\Models\Order_Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order_Status::create([
            "name"=>"Delivered"
        ]);Order_Status::create([
            "name"=>"In delivery"
        ]);Order_Status::create([
            "name"=>"Delivery failed"
        ]);
    }
}
