<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommentLike extends Model
{
    use HasFactory;
    protected $fillable=["user_id","comment_id"];
    protected $table="comments_users_likes";
    public function users()
    {
     return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }
    public function vracanje_broja($id)
    {
        $rezultat=CommentLike::where('comment_id',$id)->count();
        return $rezultat;
    }
}
