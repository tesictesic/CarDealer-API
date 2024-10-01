<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminInsertUpdateVehicleRequest;
use App\Models\AdminCRUDModel;
use App\Models\Brand;
use App\Models\Car_Body;
use App\Models\Car_Price;
use App\Models\Color;
use App\Models\Fuel;
use App\Models\Service_Pack;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Mockery\Exception;

class AdminVehicleController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabela="vehicles";
        $objekat_model=new AdminCRUDModel();
        $zapisi=$objekat_model->select_function($tabela);
        $kolone=$objekat_model->columns_for_table($tabela);
        array_push($kolone,'price','old_price');
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
        $tabela='vehicles';
        $objekat_model=new AdminCRUDModel();
        $kolone=$objekat_model->columns_for_table($tabela);
        $brands=Brand::whereNull('parent_id')->get();
        $models=Brand::where("parent_id",'!=',null)->get();
        $car_body=Car_Body::all();
        $fuel=Fuel::all();
        $color=Color::all();
        array_push($kolone,'price');
        try{
            return response()->json([[

                'table'=> $tabela,
                "niz"=>$brands,
                "niz2"=>$car_body,
                "niz3"=>$fuel,
                "niz4"=>$color,
                "niz5"=>$models
            ]]);

        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()],);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminInsertUpdateVehicleRequest $request)
    {
        $request->input('label')!=null?$label=$request->input('label'):$label=null;
        $horsepower=$request->input('horsepower');
        $seats=$request->input('seats');
        $description=$request->input('description');
        $year=$request->input('year');
        $brand_id=$request->input('brand_id');
        $model_id=$request->input('model_id');
        $car_body_id=$request->input('car_body_id');
        $fuel_id=$request->input('fuel_id');
        $color_id=$request->input('color_id');
        $price=$request->input('price');
        if($request->hasFile('image')){
            $image=$request->file('image')->getClientOriginalName();
            $this->cutImage($request);
        }
        else{
            $image='fc2';
        }


        try{
            $model_id_za_unos=Brand::where('parent_id',$brand_id)->find($model_id)->id;
            $vehicle=Vehicle::create([
                'label'=>$label,
                'horsepower'=>$horsepower,
                'seats'=>$seats,
                'description'=>$description,
                'year'=>$year,
                'image'=>$image,
                'brand_id'=>$model_id_za_unos,
                'car_body_id'=>$car_body_id,
                'fuel_id'=>$fuel_id,
                'color_id'=>$color_id
            ]);
            $vehicle_id=$vehicle->id;
            Car_Price::create([
                'vehicle_id'=>$vehicle_id,
                'price'=>$price,
                'date_of'=>date('Y-m-d')
            ]);
            return response()->json([
                'status'=>true
            ]);
        }
        catch (Exception $e){
            \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()],);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tabela='vehicles';
        $objekat_model=new AdminCRUDModel();
        $kolone=$objekat_model->columns_for_table($tabela);
        $objekat=$objekat_model->select_function('vehicles',null,null,$id);
        array_push($kolone,'price');
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
    public function update(Request $request,$id)
    {
        $request->input('label')!=null?$label=$request->input('label'):$label=null;
        $horsepower=$request->input('horsepower');
        $seats=$request->input('seats');
        $description=$request->input('description');
        $year=$request->input('year');
        $brand_id=$request->input('brand_id');
        $model_id=$request->input('model_id');
        $car_body_id=$request->input('car_body_id');
        $fuel_id=$request->input('fuel_id');
        $color_id=$request->input('color_id');
        $price=$request->input('price');
        $vehicle_objekt=Vehicle::find($id);
        if($request->hasFile('image')){
            $image=$request->file('image')->getClientOriginalName();
            $this->cutImage($request);
        }
        else{
            $image=$vehicle_objekt->image;
        }
        try{
            $model_id_za_unos=Brand::where('parent_id',$brand_id)->find($model_id)->id;
            $vehicle_objekt->label=$label;
            $vehicle_objekt->horsepower=$horsepower;
            $vehicle_objekt->seats=$seats;
            $vehicle_objekt->description=$description;
            $vehicle_objekt->year=$year;
            $vehicle_objekt->image=$image;
            $vehicle_objekt->brand_id=$model_id_za_unos;
            $vehicle_objekt->car_body_id=$car_body_id;
            $vehicle_objekt->fuel_id=$fuel_id;
            $vehicle_objekt->color_id=$color_id;
            $vehicle_objekt->save();
            Car_Price::where('vehicle_id',$id)->update(['price' => $price, 'date_of' => date('Y-m-d')]);
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
    public function destroy($id)
    {
        $vehicle_objekat=Vehicle::find($id);
        try{
            $vehicle_objekat->price()->delete();
            $vehicle_objekat->delete();
            return response()->json([
                'status' => 'true',

            ], 204);
        }
        catch (\Exception $e){
            Log::error('Greška: ' . $e->getMessage());
            return response()->json(['error' => "You cannot delete this vehicle"], 500);
        }

    }
}
