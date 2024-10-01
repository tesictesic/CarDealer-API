<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminCRUDModel extends Model
{
    use HasFactory;
    public function select_function($tabela,$tabela_veze=null,$tabela_strani_kljucevi=null,$id_prosledjen=null)
    {
        // $tabela="vehicles"
        // $tabela_veze=["fuels","body_type","brands","car_price","colors"...]
        // $tabela_strani_kljuc=['fuel_id",'body_type_id","brands_id,""
        $podaci=DB::table($tabela);
        if($tabela=='brands'){
           $podaci=$podaci->where('parent_id','=',null);
        }
        if($tabela=='vehicles'){
            $podaci=$podaci->join('car_price', 'vehicles.id', '=', 'car_price.vehicle_id')
                ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
                ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
                ->join('car_body', 'vehicles.car_body_id', '=', 'car_body.id')
                ->join('fuels', 'vehicles.fuel_id', '=', 'fuels.id')
                ->join('colors', 'vehicles.color_id', '=', 'colors.id')
                ->select(
                    'vehicles.*',
                    'car_price.price',
                    'parent_brands.name as brand',
                    'parent_brands.id as parent_id',
                    'brands.name as model',
                    'car_body.name as carBody',
                    'fuels.name as fuel',
                    'colors.color_name as color',
                     DB::raw('(SELECT price FROM car_price
                  WHERE car_price.vehicle_id = vehicles.id
                    AND date_to <= CURRENT_DATE
                  ORDER BY car_price.price DESC
                  LIMIT 1) as old_price'),
                )->whereNull('car_price.date_to');
        }
        if($tabela=='comments'){
            $podaci->join('users', 'comments.user_id', '=', 'users.id')
                ->join('vehicles', 'comments.vehicle_id', '=', 'vehicles.id')
                ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
                ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
                ->select(
                    DB::raw("CONCAT(parent_brands.name, ' ', brands.name, ' ', vehicles.label) as vehicles_name"),
                    DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_name"),
                    'comments.*'
                );
        }
        if($tabela_veze!=null){

           {
               for($i=0;$i<count($tabela_veze);$i++){
                   $podaci=$podaci->join($tabela_veze[$i],$tabela_veze[$i].".id",'=',$tabela.".".$tabela_strani_kljucevi[$i]);
                   if($tabela=='car_price'){
                       $x='label';
                       $koloneIzuzeti[]=$tabela. '.vehicle_id';
                   }
                   else{
                       $x='name';
                       $koloneIzuzeti[] = $tabela_veze[$i] . '.id';
                   }
                   $podaci=$podaci->select($tabela_veze[$i] . ".".$x.' as ' . $tabela_veze[$i] . '_name',$tabela.'.*');
               }

           }
        }
        if ($id_prosledjen!=null){
            if($tabela=='vehicles'){
                $podaci=$podaci->where('vehicles.id',$id_prosledjen);
            }
            else{
                $podaci=$podaci->where('id',$id_prosledjen);
            }

            $podaci=$podaci->first();
        }
        else{
            $podaci=$podaci->paginate(5);
        }
        return $podaci;
    }
    public function columns_for_table($tabela)
    {
        $kolone=Schema::getColumnListing($tabela);
        return $kolone;
    }
}
