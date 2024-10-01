<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRatingController extends Controller
{
    //
    public function user_rating(Request $request)
    {
        $user_id=$request->input('user_id');
        $car_id=$request->input('car_id');
        $stars=$request->input('rating_stars');
        try{
            DB::table('user_ratings')->insert([
                "user_id"=>$user_id,
                "vehicle_id"=>$car_id,
                "value"=>$stars
            ]);
            $user_ocenjeno= DB::table('user_ratings')
                ->select('value as ocena','vehicle_id')
                ->where('user_id', $user_id)
                ->get();
            return response()->json($user_ocenjeno);
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }
    public function user_rating_load(Request $request)
    {
        $user_id=$request->input("user_id");
        $user_ocenjeno= DB::table('user_ratings')
            ->select('value as ocena','vehicle_id')
            ->where('user_id', $user_id)
            ->get();
        return response()->json($user_ocenjeno);
    }
}
