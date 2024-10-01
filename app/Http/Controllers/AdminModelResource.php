<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminInsertUpdateModelRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use function Laravel\Prompts\select;

class AdminModelResource extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabela = 'models';
        $models_with_brands = DB::table('brands')
            ->join('brands as parent_brand', 'brands.parent_id', '=', 'parent_brand.id')
            ->select(
                'brands.id',
                'brands.name as model_name',
                'parent_brand.name as brand_name',
                'brands.created_at',
                'brands.updated_at'

            )->paginate(8);
        $kolone = ['id','model_name', 'brand_name','created_at','updated_at'];
        try {
            return response()->json([
                'data' => $models_with_brands,
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
        $kolone=['model_name','brand_id'];
        $tabela='models';
        $models_with_brands=DB::table('brands')
            ->where('parent_id',null)
            ->select('brands.id','brands.name')
            ->get();
        try{
            return response()->json([
                'tabela'=>$tabela,
                'niz'=>$models_with_brands,

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
    public function store(AdminInsertUpdateModelRequest $request)
    {
        $parent_id=$request->input('brand_id');
        $model_name=$request->input('model_name');
        try{
            Brand::create([
                'name'=>$model_name,
                'parent_id'=>$parent_id
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $objekat=DB::table('brands')
            ->join('brands as parent_brand','brands.parent_id','=','parent_brand.id')
            ->select(
                'brands.parent_id as parent',
                'brands.id',
                'brands.name as model_name',

            )->where('brands.id',$id)->first();
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'model_name'=>"required",
            'brand_id'=>[
                'required',
                Rule::exists('brands','id')->whereNull('parent_id')
            ]
        ]);
        $parent_id=$request->input('brand_id');
        $model_name=$request->input('model_name');
        try{
            $objekat=Brand::find($id);
            $objekat->name=$model_name;
            $objekat->parent_id=$parent_id;
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
    public function destroy($id)
    {
        $objekat=Brand::find($id);
        try{
            $objekat->delete();
            return response()->json([
                'status' => 'true',

            ], 204);
        }
        catch (\Exception $e){
            Log::error('Greška: ' . $e->getMessage());
            return response()->json(['error' => "You cannot delete this model"], 500);
        }
    }
}
