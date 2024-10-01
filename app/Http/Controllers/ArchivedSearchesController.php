<?php

namespace App\Http\Controllers;

use App\Models\ArchivedSearches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ArchivedSearchesController extends Controller
{
    public function getAll()
    {
        $svi=ArchivedSearches::all();
    }
    public function archive_insert(Request $request)
    {
        $name=$request->input('name');
        $object=$request->input('objekat');
        $user_id=$request->input('user_id');
        try{
            ArchivedSearches::create([
                'name'=>$name,
                'search_parameters'=>json_encode($object),
                'user_id'=>$user_id,
                'date_of_archiving'=>date('Y-m-d H:i:s')
            ]);
            $objekat_searches=new ArchivedSearches();
            $svi=$objekat_searches->getAll($user_id);
        return response()->json($svi);
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }
    public function archive_delete(Request $request)
    {
        $id=$request->input('id');
        $id_user=Session::get('user')->id;
        try{
            $objekat=ArchivedSearches::find($id)->delete();
            $svi=new ArchivedSearches();
            $svi=$svi->getAll($id_user);
            return response()->json($svi);
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
