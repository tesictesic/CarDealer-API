<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;
    public function commentsAll($id,$page,$user_id=null)
    {
        $result = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('comments_users_likes', 'comments_users_likes.comment_id', '=', 'comments.id')
            ->where('comments.vehicle_id', $id)

            ->orderByDesc('comments.date')
            ->select([
                'comments.id',
                'comments.text',
                'users.first_name',
                'users.last_name',
                'users.picture',
                DB::raw('CONCAT(DAY(comments.date), "/", MONTH(comments.date), "/", YEAR(comments.date)) as date'),
                DB::raw('COUNT(comments_users_likes.id) AS like_count'),
                DB::raw("MAX(IF(comments_users_likes.user_id = $user_id, 1, 0)) AS user_has_liked")
            ])->groupBy('comments.id', 'comments.text','users.first_name','users.last_name','users.picture','comments.date')
            ->paginate(4,$page);

        return $result;
    }
    public function commentsAdd($user_id,$vehicle_id,$text)
    {
        $datum = now()->format('Y-m-d H:i:s');
        $rezultat=DB::table('comments')->insert([
            "user_id"=>$user_id,
            "vehicle_id"=>$vehicle_id,
            "text"=>$text,
            "date"=>$datum
        ]);
        return $rezultat;
    }
    public function comments_likes()
    {
        return $this->hasMany(CommentLike::class);
    }
}
