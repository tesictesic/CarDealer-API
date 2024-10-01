<?php

namespace App\Http\Controllers;

use App\Models\AdminBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function index()
    {
        $objekat_logovi=new AdminBase();
        $logs=$objekat_logovi->getLogs();
        return view('adminPanel.pages.home',['logs'=>$logs]);
    }
    public function sort_filter(Request $request)
    {
        $filter_sort=$request->input('log_type');
        $date_to=$request->input('date_to');
        $date_of=$request->input('date_of');
        $page=$request->input('page');
        $objekat_logovi=new AdminBase();
        $logs=$objekat_logovi->getLogs($filter_sort,$date_of,$date_to,$page);
        return response()->json($logs);
    }
}
