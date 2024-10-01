<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreNameColumnRequest;
use App\Models\AdminCRUDModel;
use App\Models\Fuel;
use Illuminate\Http\Request;

class AdminFuelResource extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabela="fuels";
        $objekat_model=new AdminCRUDModel();
        $zapisi=$objekat_model->select_function($tabela);
        $kolone=$objekat_model->columns_for_table($tabela);
        return view('adminPanel.pages.select',['data'=>$zapisi,"columns"=>$kolone,"tabela"=>$tabela]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tabela="fuels";
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
            Fuel::create([
                'name'=> $name
            ]);
            return redirect()->route($tabela.".index");
        }
        catch (\Exception $e){
            dd($e->getMessage());
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
        $tabela="fuels";
        $objekat_model=new AdminCRUDModel();
        $kolone=$objekat_model->columns_for_table($tabela);
        $objekat=$objekat_model->select_function($tabela,null,null,$id);
        return view("adminPanel.pages.edit",["tabela"=>$tabela,"kolone"=>$kolone,"objekat"=>$objekat,"ddl1"=>null,"ddl2"=>null,"ddl3"=>null,"ddl4"=>null,"ddl5"=>null]);
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
            $objekat=Fuel::find($id);
            $objekat->name=$name;
            $objekat->save();
            return redirect()->route('fuels.index');
        }catch (\Exception $e){
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $objekat=Fuel::find($id);
        try{
            $objekat->delete();
            return response()->json(['success' => true]);
        }catch (\Exception $e){
            return response()->json(['error' => 'cannot be deleted due to referential integrity']);
        }
    }
}
