<?php

namespace App\Http\Controllers;

use App\Models\ArchivedSearches;
use App\Models\Brand;
use App\Models\Car_Body;
use App\Models\Fuel;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CarsController extends BaseController
{
    private $data;
    public function getModel($id)
    {
        $brand=Brand::find($id);
        $model=$brand->children;
        return response()->json([
            'status' => true,

            'items'=>$model,

        ]);
    }
    public function index(Request $request)
    {

        $marka=Brand::whereNull('parent_id')->get();
        $gorivo=Fuel::all();
        $karoserija=Car_Body::all();
        $this->data['marka']=$marka;
        $this->data['goriva']=$gorivo;
        $this->data['karoserije']=$karoserija;
        $sva_auta=new Vehicle();

        $this->data['auta']=$sva_auta;
        if(Session::has('user')){
            $user_id=Session::get('user')->id;
            $objekat_searches=new ArchivedSearches();
            $svi=$objekat_searches->getAll($user_id);
            $this->data['bookmars']=$svi;
        }
    try{
        return response()->json([
            'status' => true,

            'brands'=>$this->data['marka'],
            'fuel'=>$this->data['goriva'],
            'type_of_cars'=>$this->data['karoserije'],
            'cars'=>$sva_auta->GetCarWithOrWithoutElement(null,$request->all())
        ]);

    }
    catch (\Exception $e){
        Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
        return response()->json(['error' => 'Došlo je do greške.'], 500);
    }

    }

    public function getCarWithId($id)
    {
        $sva_auta=new Vehicle();
        $rezultat=$sva_auta->GetCarWithOrWithoutElement($id);
        return response()->json([
            'status' => true,

            'item'=>$rezultat,

        ]);
    }
    public function pagination(Request $request)
    {
        $sva_auta=new Vehicle();
        $rezultat=$sva_auta->GetCarWithOrWithoutElement($id=null,$request->all());
        return response()->json([
            'status' => true,

            'brands'=>$rezultat,

        ]);
    }
    public function getCarsAndFilterCars(Request $request)
    {
        $sva_auta=new Vehicle();
        $rezultat=$sva_auta->GetCarWithOrWithoutElement($id=null,$request->all());
        return response()->json([
        'status' => true,

        'brands'=>$rezultat,

    ]);
    }
}
