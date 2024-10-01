<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreNameColumnRequest;
use App\Models\AdminCRUDModel;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabela="roles";
        $objekat_model=new AdminCRUDModel();
        $zapisi=$objekat_model->select_function($tabela);
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
    public function create()
    {
        $tabela="roles";
        $objekat_model=new AdminCRUDModel();
        $kolone=$objekat_model->columns_for_table($tabela);
        return view('adminPanel.pages.insert',['columns'=>$kolone,'tabela'=>$tabela,'niz'=>null,"niz2"=>null,"niz3"=>null,"niz4"=>null,"niz5"=>null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStoreNameColumnRequest $request)
    {
        $name=$request->input('name');
        $tabela=$request->input('table');
        try{
            Role::create([
                'name'=> $name
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
    public function edit(string $id)
    {
        $tabela="roles";
        $objekat_model=new AdminCRUDModel();
        $objekat=$objekat_model->select_function($tabela,null,null,$id);
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
            "name"=>'required|min:2'
        ]);
        $name=$request->input('name');
        try{
            $objekat=Role::find($id);
            $objekat->name=$name;
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
    public function destroy( $id)
    {
        $objekat=Role::find($id);
        try{
            $objekat->delete();
            return response()->json([
                'status' => 'true',

            ], 204);
        }
        catch (\Exception $e){
            Log::error('Greška: ' . $e->getMessage());
            return response()->json(['error' => "You cannot delete this role"], 500);
        }
    }
}
