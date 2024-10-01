<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fejker=Faker::create();
        for($i=0;$i<5;$i++){
            DB::table('comments')->insert([
               "user_id"=>1,
               "vehicle_id"=>rand(1,17),
               "text"=>$fejker->text(),
               "date"=>$fejker->date()
            ]);
        }
    }
}
