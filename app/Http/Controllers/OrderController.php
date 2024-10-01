<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class OrderController extends BaseController
{

    public function order_store(Request $request)
    {
        $request->validate([
            "location"=>'required'
        ]);
        $vehicle_id=$request->input('vehicleId');
        $user_id=$request->input('userId');
        $user_objekat=User::find($user_id);
        $vozilo=DB::table('vehicles')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->select(
                'parent_brands.name as marka_naziv',
                'brands.name as model_naziv',
                'vehicles.label'
            )->where('vehicles.id',$vehicle_id)->first();
        $lokacija=$request->input('location');
        $status_id=2;
        try{
            Order::create([
               "location"=>$lokacija,
               "user_id"=>$user_id,
               "vehicle_id"=>$vehicle_id,
               "status_id"=>$status_id
            ]);
            $message = $user_objekat->first_name." ".$user_objekat->last_name." with his email: ".$user_objekat->email." has ordered ".$vozilo->marka_naziv." ".$vozilo->model_naziv." ".$vozilo->label." on: ".now();
            $log_type=4;
            Log::create([
                'value'=>$message,
                'logs_type_id'=>$log_type
            ]);
            return response()->json([
                'success'=>"You have succesfull ordered your car. Check your profile to follow your delivery"
            ]);
        }catch (Exception $e){
            return response()->json([
                'error'=>$e->getMessage()
            ]);
        }

    }
    public function order_change_status(){
        $orders=Order::where('status_id',2)->get();
    try{
        foreach ($orders as $order){
            $createdAt = Carbon::parse($order->created_at);
            $currentTime = now();

            if ($createdAt->diffInMinutes($currentTime) >= 1) {
                $order->update(['status_id' => 1]);
            }
        }
        return response()->json();
    }
    catch (Exception $ex){
        \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $ex->getMessage());
        return response()->json([
            'error'=>$ex->getMessage()
        ]);
        }

    }

}
