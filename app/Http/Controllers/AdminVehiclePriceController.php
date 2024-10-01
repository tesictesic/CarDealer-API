<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminInsertUpdateCarPriceRequest;
use App\Models\AdminCRUDModel;
use App\Models\Car_Price;
use App\Models\Role;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class AdminVehiclePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabela="car_price";
        $tabela_veze=['vehicles'];
        $tabela_veze_strani_kljuc=['vehicle_id'];
        $objekat_model=new AdminCRUDModel();
        $zapisi=$objekat_model->select_function($tabela,$tabela_veze,$tabela_veze_strani_kljuc);
        $kolone=$objekat_model->columns_for_table($tabela);
        try {
            return response()->json([
                'data' => $zapisi,
                "columns" => $kolone,
                'tabela' => $tabela
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()],);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getP()
    {
        $tabela='car_price';
        $objekat_model=new AdminCRUDModel();
        $kolone=$objekat_model->columns_for_table($tabela);
        $vehicle_ddl=DB::table('vehicles')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->join('fuels', 'vehicles.fuel_id', '=', 'fuels.id')
            ->join('colors', 'vehicles.color_id', '=', 'colors.id')
            ->select(
                'vehicles.*',
                'parent_brands.name as marka_naziv',
                'brands.name as model_naziv',
            )->get();
        $tmp=[];
        foreach ($vehicle_ddl as $veh){
            array_push($tmp,['id'=>$veh->id,'name'=>$veh->marka_naziv." ".$veh->model_naziv." ".$veh->label]);
        }
       try{
           return response()->json([
               'tabela'=>$tabela,
               "niz"=>$tmp
           ]);
       }
       catch (\Exception $e) {
           \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
           return response()->json(['error' => $e->getMessage()],);
       }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminInsertUpdateCarPriceRequest $request)
    {
       $vehicle_id=$request->input('vehicle_id');
       $price=$request->input('price');
       $date_of=$request->input('date_of');
       $date_to=$request->input('date_to');
       try{
           Car_Price::create([
               'vehicle_id'=>$vehicle_id,
               'price'=>$price,
               'date_of'=>$date_of,
               'date_to'=>$date_to
           ]);
           return response()->json([
               'status'=>true
           ]);
       }
       catch (\Exception $e){
           \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
           return response()->json(['error' => $e->getMessage()],);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tabela="car_price";
        $objekat_model=new AdminCRUDModel();

        $objekat=DB::table('vehicles')
            ->join('car_price', 'vehicles.id', '=', 'car_price.vehicle_id')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->join('car_body', 'vehicles.car_body_id', '=', 'car_body.id')
            ->join('fuels', 'vehicles.fuel_id', '=', 'fuels.id')
            ->join('colors', 'vehicles.color_id', '=', 'colors.id')
            ->select(
                'vehicles.*',
                'car_price.price',
                'car_price.date_of',
                'car_price.date_to',
                'parent_brands.name as marka_naziv',
                'brands.name as model_naziv',
                'car_body.name as karoserija_naziv',
                'fuels.name as gorivo_naziv',
                'colors.color_name as boja_naziv'
            )->where('vehicles.id',$id)->first();
        try{
            return response()->json([

                "objekat"=>$objekat,
            ]);
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()],);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminInsertUpdateCarPriceRequest $request, $id)
    {
        $vehicle_id=$request->input('vehicle_id');
        $price=$request->input('price');
        $date_of=$request->input('date_of');
        $date_to=$request->input('date_to');
        try{
            $objekat=Car_Price::find($id);
            $objekat->vehicle_id=$vehicle_id;
            $objekat->price=$price;
            $objekat->date_of=$date_of;
            $objekat->date_to=$date_to;
            $objekat->save();
            return response()->json([
                'status'=>true
            ],204);
        }
        catch (\Exception $e){
            \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $objekat=Car_Price::find($id);
        try{
            $objekat->delete();
            return response()->json([
                'status' => 'true',

            ], 204);
        }
        catch (\Exception $e){
            Log::error('Greška: ' . $e->getMessage());
            return response()->json(['error' => "You cannot delete this price"], 500);
        }
    }
}
