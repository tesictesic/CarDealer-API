<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable=['label','horsepower','seats','description','year','image','brand_id','car_body_id','fuel_id','color_id'];

    public function car_body()
    {
        return $this->belongsTo(Car_Body::class,'car_body_id');
    }
    public function price()
    {
        return $this->hasMany(Car_Price::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function fuel()
    {
        return $this->belongsTo(Fuel::class);
    }
    public function GetCarWithOrWithoutElement($id=null,$objekat=null)
    {
        $sva_auta = DB::table('vehicles')
            ->select(
                'vehicles.*',
                'car_price.price',
                'parent_brands.name as brand',
                'brands.name as model',
                'car_body.name as body',
                'fuels.name as fuel',
                'colors.color_name as color',
                DB::raw('(SELECT price FROM car_price
                  WHERE car_price.vehicle_id = vehicles.id
                    AND date_to <= CURRENT_DATE
                  ORDER BY car_price.price DESC
                  LIMIT 1) as oldPrice'),
                DB::raw('(SELECT COUNT(*) FROM orders WHERE orders.vehicle_id = vehicles.id AND orders.status_id = 1) as numberOfPurchase')
            )
            ->join('car_price', 'vehicles.id', '=', 'car_price.vehicle_id')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->join('car_body', 'vehicles.car_body_id', '=', 'car_body.id')
            ->join('fuels', 'vehicles.fuel_id', '=', 'fuels.id')
            ->join('colors', 'vehicles.color_id', '=', 'colors.id')
            ->whereNull('car_price.date_to');
             if($id!=null){
                $sva_auta=$sva_auta->where('vehicles.id',$id)->first();

            }
            else{
                if(isset($objekat['brandId'])) $sva_auta=$sva_auta->where('parent_brands.id',$objekat['brandId']);
                if(isset($objekat['modelId'])) $sva_auta=$sva_auta->where('brands.id',$objekat['modelId']);
                if(isset($objekat['fuelId'])) $sva_auta=$sva_auta->where('fuels.id',$objekat['fuelId']);
                if(isset($objekat['body_typeId'])) $sva_auta=$sva_auta->where('car_body.id',$objekat['body_typeId']);
                if(isset($objekat['price_from'])&& isset($objekat['price_to'])) $sva_auta=$sva_auta->whereBetween('car_price.price',[$objekat['price_from'],$objekat['price_to']]);
                if(isset($objekat['price_from'])&& (!isset($objekat['price_to']))) $sva_auta=$sva_auta->where('car_price.price','>=',$objekat['price_from']);
                if (!isset($objekat['price_from']) && isset($objekat['price_to'])) $sva_auta = $sva_auta->where('car_price.price', '<=', $objekat['price_to']);
                if(isset($objekat['sorting'])){
                    if($objekat['sorting']=='desc'){
                        $sva_auta->orderByDesc('car_price.price');
                    }
                    else{
                        $sva_auta->orderBy('car_price.price');
                    }
                }

                if(isset($objekat['page'])){
                    $page=$objekat['page'];
                }
                else{
                    $page=1;
                }
                $sva_auta=$sva_auta->paginate(6,$page);

            }
            return $sva_auta;
    }
    public function get_users_cars($user_id)
    {
        $rezultat=DB::table('orders')
            ->join('vehicles','vehicles.id','=','orders.vehicle_id')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->select(
                'parent_brands.name as brand',
                'brands.name as model',
                'vehicles.label',
                'vehicles.id'
            )->where('orders.status_id',1)->where('orders.user_id',$user_id)
            ->get();
        return $rezultat;
    }
    public function get_car_user($user,$vehicle){
        $vehicle_user=DB::table('users')
            ->join('orders','orders.user_id','=','users.id')
            ->join('vehicles','vehicles.id','=','orders.vehicle_id')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->select(
                'parent_brands.name as brand',
                'brands.name as model',
                'vehicles.label',
                'vehicles.id as vehicle_id',
                'users.id as user_id',
                'users.first_name',
                'users.last_name',
                'users.picture',
                'vehicles.image',
            )->where('orders.status_id',1)->where('orders.user_id',$user)->where('orders.vehicle_id',$vehicle)->first();
     return $vehicle_user;
    }

}
