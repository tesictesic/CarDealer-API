<?php

namespace Database\Seeders;

use App\Models\LogsType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niz=['Login','Logout','Register','Order','Servicing'];
        foreach ($niz as $item){
            LogsType::create([
                'name'=>$item
            ]);
        }
    }
}
