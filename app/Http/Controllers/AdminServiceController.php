<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminInsertUpdateServiceRequest;
use App\Models\AdminCRUDModel;
use App\Models\Service;
use App\Models\Service_Pack;
use Illuminate\Http\Request;
use Mockery\Exception;

class AdminServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabela="services";
        $tabela_veza=["service_packs"];
        $strani_kljucevi=["service_packet_id"];
        $objekat_model=new AdminCRUDModel();
        $zapisi=$objekat_model->select_function($tabela,$tabela_veza,$strani_kljucevi);
        $kolone=$objekat_model->columns_for_table($tabela);
        return view('adminPanel.pages.select',['data'=>$zapisi,"columns"=>$kolone,"tabela"=>$tabela]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tabela='services';
        $objekat_model=new AdminCRUDModel();
        $kolone=$objekat_model->columns_for_table($tabela);
        $roles_ddl=Service_Pack::all();
        return view('adminPanel.pages.insert',['columns'=>$kolone,'tabela'=>$tabela,"niz"=>$roles_ddl,"niz2"=>null,"niz3"=>null,"niz4"=>null,"niz5"=>null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminInsertUpdateServiceRequest $request)
    {
       $service_packet_id=$request->input('service_packet_id');
       $name=$request->input('name');
       $description=$request->input('description');
       if($request->hasFile('icon')){
           $iconFileName = $request->file('icon')->getClientOriginalName();

           $iconPath = "assets/images/ikonice/".$iconFileName;

           move_uploaded_file($request->file('icon')->getPathname(), $iconPath);

           // Sada možete koristiti $iconPath za dalje korišćenje
           $icon = $iconPath;
       }
       else{
           $icon="assets/images/ikonice/diagnostika.png";
       }
       $price=$request->input('price');
       try{
           Service::create([
               'service_packet_id'=>$service_packet_id,
               'name'=>$name,
               'description'=>$description,
               'icon'=>$icon,
               'price'=>$price
           ]);
           return redirect()->route('servicing.index');
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


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tabela="services";
        $objekat_model=new AdminCRUDModel();
        $kolone=$objekat_model->columns_for_table($tabela);
        $objekat=$objekat_model->select_function($tabela,null,null,$id);
        $roles_ddl=Service_Pack::all();
        return view("adminPanel.pages.edit",["tabela"=>$tabela,"kolone"=>$kolone,"objekat"=>$objekat,"ddl1"=>$roles_ddl,"ddl2"=>null,"ddl3"=>null,"ddl4"=>null,"ddl5"=>null]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminInsertUpdateServiceRequest $request,$id)
    {
        $service_packet_id=$request->input('service_packet_id');
        $name=$request->input('name');
        $description=$request->input('description');
        $price=$request->input('price');
        $objekat=Service::find($id);
        if($request->hasFile('icon')){
            $iconFileName = $request->file('icon')->getClientOriginalName();

            $iconPath = "assets/images/ikonice/".$iconFileName;

            move_uploaded_file($request->file('icon')->getPathname(), $iconPath);

            // Sada možete koristiti $iconPath za dalje korišćenje
            $icon = $iconPath;
        }
        else{
            $icon=$objekat->icon;
        }
        try{
            $objekat->service_packet_id=$service_packet_id;
            $objekat->name=$name;
            $objekat->description=$description;
            $objekat->icon=$icon;
            $objekat->price=$price;
            $objekat->save();
            return redirect()->route('servicing.index');
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $objekat=Service::find($id);
        try{
            $objekat->delete();
            return response()->json(['success' => true]);
        }catch (Exception $e){
            return response()->json(['error' => 'cannot be deleted due to referential integrity']);
        }
    }
}
