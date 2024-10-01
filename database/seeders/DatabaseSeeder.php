<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Car_Body;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //]);
        $this->call([
              BrandSeeder::class,
              ColorSeeder::class,
              FuelSeeder::class,
              Car_BodySeeder::class,
              VehicleSeeder::class,
              Car_BodySeeder::class,
              Car_PriceSeeder::class,
              ServicePackSeeder::class,
              ServiceSeeder::class,
              RoleSeeder::class,
              UserSeeder::class,
              OrderStatusSeeder::class,
              CommentsSeeder::class,
              LogsTypeSeeder::class


        ]);
    }
}
