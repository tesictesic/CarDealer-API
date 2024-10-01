<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminBase extends Model
{
    use HasFactory;
    public function getLogs($log_filter=null,$date_of=null,$date_to=null,$page=null)
    {
        $logs=DB::table('logs')
            ->join('logs_type','logs.logs_type_id','=','logs_type.id')
            ->select(
                "logs.value",
                "logs_type.name"
            )->orderBy('logs.created_at','asc');
        if($date_of!=null){
            $logs=$logs->where('logs.created_at','>=',$date_of);
        }
        if($date_to!=null){
            $logs=$logs->where('logs.created_at','<=',$date_to);
        }
        if($date_of!=null&&$date_to!=null){
            $logs=$logs->where('logs.created_at','>=',$date_of)->where('logs.created_at','<=',$date_to);
        }
            if($log_filter!=null){
                if(($log_filter=='Login')||($log_filter=='Logout')||($log_filter=='Register')||($log_filter=='Order')||($log_filter=='Servicing')){
                    $logs=$logs->where('logs_type.name',$log_filter);
                }
            }
            $logs=$logs->paginate(8,$page);
        return $logs;
    }
}
