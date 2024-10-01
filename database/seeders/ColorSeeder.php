<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Color::create(['color_name' => 'black']);
        Color::create(['color_name' => 'red']);
        Color::create(['color_name' => 'gray']);
        Color::create(['color_name' => 'blue']);
        Color::create(['color_name' => 'white']);
        Color::create(['color_name' => 'light green']);
        Color::create(['color_name' => 'dark green']);
        Color::create(['color_name' => 'dark blue']);
    }
}
