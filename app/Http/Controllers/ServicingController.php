<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Service_Pack;
use App\Models\ServiceItems;
use App\Models\Servicing;
use App\Models\User;
use App\Models\Vehicle;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use function Laravel\Prompts\table;

class ServicingController extends BaseController
{
    public function index()
    {
        $user_id=Session::get('user')->id;
        $objekat=new Vehicle();
        $vehicles=$objekat->get_users_cars($user_id);
        return view('pages.servicing',['vehicles'=>$vehicles]);
    }
    public function servicePanelIndex(Request $request)
    {
        $vehicle=$request->input('vehicle_id');
        $user=$request->input('user_id');
        if(($user==null)|| ($vehicle==null)) return redirect()->back();
        $objekat=new Vehicle();
        $vehicle_user=$objekat->get_car_user($user,$vehicle);
        $usluge=Service::all();
        $servispaketi=Service_Pack::all();
        return view('pages.servicepanel',['vehicle'=>$vehicle,"usluge"=>$usluge,"servispaketi"=>$servispaketi,'vehicle_user'=>$vehicle_user]);

    }
    public function getPanelIndex(Request $request)
    {
        $selectedUsluge = $request->query('selectedUsluge');
        $filtered=DB::table('services')->whereIn('id',$selectedUsluge)->get();
        return response()->json(['filteredUsluge' => $filtered]);
    }

    /**
     * @throws \Exception
     */
    public function invoice(Request $request)
    {
        $request->validate([
            'services'=>'required|exists:services,id',
            'date'=>'required|date|after_or_equal:'.now(),
            'note'=>'nullable|min:10|max:500'
        ]);
        $usluge=$request->input('services');
        $vehicle_user=$request->input('vehicle_user');
        $date=$request->input('date');
        $note=$request->input('note');
        $vehicle_user_decode=json_decode($vehicle_user);
        $user_id=$vehicle_user_decode->user_id;
        $dateTime = new DateTime($date);
        $formatiranDatum = $dateTime->format("d M Y");
        $user_objekat=DB::table('users')
                      ->join('roles','roles.id','=','users.role_id')
                      ->where('users.id',$user_id)
                      ->select(
                          "users.*",
                                "roles.name as role_name"
                      )->first();
        $servisi=DB::table('services')
                    ->join('service_packs','services.service_packet_id','=','service_packs.id')
                    ->whereIn('services.id',$usluge)
                    ->select(
                        'services.*',
                                'service_packs.name as service_name'
                    )
                    ->distinct()
                    ->get();
        return view('pages.invoice',['usluge'=>$servisi,'vehicle_user'=>$vehicle_user_decode,'full_user'=>$user_objekat,'date'=>$formatiranDatum,'note'=>$note,'services_id'=>$usluge,'date_insert'=>$date]);
    }
    public function insert_services(Request $request)
    {
        $user_id=$request->input('user_id');
        $vehicle_id=$request->input('vehicle_id');
        $services=$request->input('services_id');
        $sevices_id_decode=json_decode($services);
        $date=$request->input('date');
        $note=$request->input('note');
       try{
           $order_vehicle_delivered=Order::where('user_id',$user_id)->where('vehicle_id',$vehicle_id)->where('status_id',1)->first();
           $order_id=$order_vehicle_delivered->id;
           $objekat_service=Servicing::create([
               'order_id'=>$order_id,
               'user_id'=>$user_id,
               'date_to'=>$date,
               'note'=>$note
           ]);
           $id_servicing=$objekat_service->id;
           foreach ($sevices_id_decode as $element){
               ServiceItems::create([
                   'servicing_id'=>$id_servicing,
                   'service_id'=>$element
               ]);
           }
           return redirect()->back()->with('success','YOu have successfull order a service. Check your profile to view information about your services');
       }
       catch (Exception $e){
           dd($e->getMessage());
       }


    }
}
