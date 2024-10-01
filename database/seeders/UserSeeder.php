<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin=["first_name"=>"Djordje","last_name"=>"Tesic","email"=>"djordje.tesa@gmail.com","password"=>'$2y$12$JJ4WAUIlWLzEFQ4k5n7d5uehMTweq9DESSVn8jay3jn2QnBi0/JNe','picture'=>'user.png','role_id'=>1];
        User::create($admin);
    }
}
