<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function prikaz_komentara(Request $request)
    {
      $objekat=new Comment();
      $rezultat=$objekat->commentsAll($request->input('vehicle_id'),$request->input('page'),$request->input('user_id')!=null?$request->input('user_id'):null);
      return response()->json($rezultat);
    }
    public function unos_komentara(Request $request)
    {
     $user_id=$request->input('user_id');
     $vehicle_id=$request->input('vehicle_id');
     $text=$request->input('comment_text');
     $page=$request->input('page');
     $objekat=new Comment();
     $poruka=$objekat->commentsAdd($user_id,$vehicle_id,$text);
     if($poruka){
         $rezultat=$objekat->commentsAll($vehicle_id,$page,$user_id);
         return response()->json($rezultat);
     }

    }
}
