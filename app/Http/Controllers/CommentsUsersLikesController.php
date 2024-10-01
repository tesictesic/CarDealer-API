<?php

namespace App\Http\Controllers;

use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsUsersLikesController extends Controller
{
    public function update_like(Request $request)
    {
        $user_id=$request->input('user_id');
        $comment_id=$request->input('comment_id');
        $type=$request->input('type');
        $objekat=new CommentLike();
        if($type=="insert"){
            CommentLike::create([
               "user_id"=>$user_id,
                "comment_id"=>$comment_id
            ]);

            $rezultat=$objekat->vracanje_broja($comment_id);
            return response()->json($rezultat);
        }
        else{
            CommentLike::where("user_id",$user_id)->where("comment_id",$comment_id)->first()->delete();
            $rezultat=$objekat->vracanje_broja($comment_id);
            return response()->json($rezultat);
        }
    }
}
