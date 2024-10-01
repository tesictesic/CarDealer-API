<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArchivedSearches extends Model
{
    use HasFactory;
    protected $fillable=['name','search_parameters','user_id','date_of_archiving'];
    protected $table='user_archived_searches';
    public function getAll($user_id)
    {
        $svi=DB::table('user_archived_searches')
            ->join('users','user_archived_searches.user_id','=','users.id')
            ->select('user_archived_searches.name',
                'user_archived_searches.search_parameters',
                'user_archived_searches.date_of_archiving',
                'user_archived_searches.id',
                'users.first_name',
                'users.last_name',
            )->where('user_id',$user_id)->get();
        foreach ($svi as $result) {
            $result->search_parameters = json_decode($result->search_parameters);
            if (isset($result->search_parameters->brend_id)) {
                $brand_id = $result->search_parameters->brend_id;
                $brand_name = DB::table('brands')->where('id', $brand_id)->where('parent_id',null)->value('brands.name as brand_name');
                $result->brand_name = $brand_name;
            }
            if (isset($result->search_parameters->model_id)) {
                $model_id = $result->search_parameters->model_id;
                $model_name = DB::table('brands')
                    ->where('id', $model_id)->where('parent_id','!=',null)->value('brands.name as model_name');
                $result->model_name = $model_name;
            }
            if (isset($result->search_parameters->karoserija_id)) {
                $karoserija_id = $result->search_parameters->karoserija_id;
                $karoserija_name = DB::table('car_body')->where('id', $karoserija_id)->value('car_body.name as karoserija_naziv');
                $result->karoserija_name = $karoserija_name;
            }
            if (isset($result->search_parameters->gorivo_id)) {
                $gorivo_id = $result->search_parameters->gorivo_id;
                $gorivo_name = DB::table('fuels')->where('id', $gorivo_id)->value('fuels.name');
                $result->gorivo_name = $gorivo_name;
            }
        }
        return $svi;
    }

}
