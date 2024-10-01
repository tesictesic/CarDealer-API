<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserEditRequest;
use App\Mail\RecoverPasswordMail;
use App\Models\Order;
use App\Models\Servicing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \App\Models\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use function Laravel\Prompts\select;

class UserController extends  BaseController
{
    public function index(Request $request)
    {
        $user_id=$request['userId'];
        $page=$request['page'];
        $user = User::with('role')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->select('users.*', 'roles.name as roleName')
            ->find($user_id);
        $user_narudzbine=DB::table('users')
            ->join('orders','orders.user_id','users.id')
            ->join('orders_status','orders_status.id','=','orders.status_id')
            ->join('vehicles','vehicles.id','=','orders.vehicle_id')
            ->join('car_price', 'vehicles.id', '=', 'car_price.vehicle_id')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->join('car_body', 'vehicles.car_body_id', '=', 'car_body.id')
            ->join('fuels', 'vehicles.fuel_id', '=', 'fuels.id')
            ->join('colors', 'vehicles.color_id', '=', 'colors.id')
            ->select(
                'vehicles.*',
                'car_price.price',
                'parent_brands.name as marka_naziv',
                'brands.name as model_naziv',
                'car_body.name as karoserija_naziv',
                'fuels.name as gorivo_naziv',
                'colors.color_name as boja_naziv',
                'orders_status.name as status_name',
                'orders.location as location',
                'orders.created_at as datum',
                'orders.status_id as status_id',
                DB::raw('(SELECT price FROM car_price
                  WHERE car_price.vehicle_id = vehicles.id
                    AND date_to <= CURRENT_DATE
                  ORDER BY car_price.price DESC
                  LIMIT 1) as old_price'),
            )->whereNull('car_price.date_to')
            ->where('orders.user_id',$user_id)
            ->paginate(4,$page);
        $user_liked_vehicles=DB::table('users')
            ->join('user_ratings','user_ratings.user_id','=','users.id')
            ->join('vehicles','vehicles.id','=','user_ratings.vehicle_id')
            ->join('car_price', 'vehicles.id', '=', 'car_price.vehicle_id')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->join('car_body', 'vehicles.car_body_id', '=', 'car_body.id')
            ->join('fuels', 'vehicles.fuel_id', '=', 'fuels.id')
            ->join('colors', 'vehicles.color_id', '=', 'colors.id')
            ->select(
                'vehicles.*',
                'car_price.price',
                'parent_brands.name as marka_naziv',
                'brands.name as model_naziv',
                'car_body.name as karoserija_naziv',
                'fuels.name as gorivo_naziv',
                'colors.color_name as boja_naziv',
                "user_ratings.value",
                DB::raw('(SELECT price FROM car_price
                  WHERE car_price.vehicle_id = vehicles.id
                    AND date_to <= CURRENT_DATE
                  ORDER BY car_price.price DESC
                  LIMIT 1) as old_price'),
            )->whereNull('car_price.date_to')
            ->where('user_ratings.user_id',$user_id)
            ->get();
        $user_liked_count=DB::table('users')
                            ->join('user_ratings','user_ratings.user_id','=','users.id')
                            ->where('user_ratings.user_id',$user_id)->count();
        $user_liked_comments=DB::table('users')
                            ->join('comments_users_likes','comments_users_likes.user_id','=','users.id')
                             ->where('comments_users_likes.user_id',$user_id)->count();
        $user_cars=DB::table('orders')->where('user_id',$user_id)->where('status_id',1)->count();
        $items = DB::table('servicing')
            ->join('servicing_items', 'servicing_items.servicing_id', '=', 'servicing.id')
            ->join('services', 'servicing_items.service_id', '=', 'services.id')
            ->join('orders', 'orders.id', '=', 'servicing.order_id')
            ->join('vehicles', 'vehicles.id', '=', 'orders.vehicle_id')
            ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
            ->join('brands as parent_brands', 'brands.parent_id', '=', 'parent_brands.id')
            ->join('car_price', 'vehicles.id', '=', 'car_price.vehicle_id')
            ->where('orders.status_id', 1)
            ->where('servicing.user_id', $user_id)
            ->select(
                'parent_brands.name as marka_naziv',
                'brands.name as model_naziv',
                'vehicles.label',
                'vehicles.id',
                DB::raw('GROUP_CONCAT(services.name) as services'),
                DB::raw('SUM(services.price) as total_price'), // Ukupna cena za sve usluge
                 DB::raw('(SELECT price FROM car_price
                  WHERE car_price.vehicle_id = vehicles.id
                    AND date_to <= CURRENT_DATE
                  ORDER BY car_price.price DESC
                  LIMIT 1) as old_price'),
                )->whereNull('car_price.date_to')
            ->groupBy('vehicles.id', 'marka_naziv', 'model_naziv', 'vehicles.label')
            ->get();

// Formatiranje rezultata
        $formattedItems = [];
        foreach ($items as $item) {
            $formattedItems[] = [
                'marka_naziv' => $item->marka_naziv,
                'model_naziv' => $item->model_naziv,
                'label' => $item->label,
                'id' => $item->id,
                'services' => $item->services ?: '',
                'total_price' => $item->total_price,
            ];
        }
        try{
            return response()->json([
                'user' => $user,
                'userOrders'=>$user_narudzbine,
                'userLikedCarsCount'=>$user_liked_vehicles,
                'userLikedCommentsCount'=>$user_liked_comments,
                'userCars'=>$user_cars


            ], 200);
        }
        catch (\Exception $e){
            \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], );
        }
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user_objekat = User::with('role')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('email', $email)
            ->select('users.*', 'roles.name as role_name')
            ->first();

        if (!$user_objekat) {
            return response()->json(['message' => 'No user found'], 404); // Vraćamo JSON odgovor za Angular
        }

        if (!Hash::check($password, $user_objekat->password)) {
            return response()->json(['message' => 'Wrong password'], 401);
        }

        // Prijava uspešna, vraćamo korisnika kao odgovor
        return response()->json($user_objekat);
    }
    public function register(RegisterRequest $request)
    {
     $first_name=$request->input('first_name');
     $last_name=$request->input('last_name');
     $email=$request->input('email');
     $password=$request->input('password');
     $role_id=2;
        $postoji_slika=$request->hasFile('picture');
        if($postoji_slika){
            $slika=$request->file('picture')->getClientOriginalName();
            $this->cutImage($request,true);
        }
        else{
            $slika="user.png";
        }

      $hesovana_sifra=Hash::make($password);
      try{
          User::create([
              "first_name"=>$first_name,
              "last_name"=>$last_name,
              "email"=>$email,
              "password"=>$hesovana_sifra,
              "picture"=>$slika,
              "role_id"=>$role_id
          ]);
          $message = $first_name." ".$last_name." with his email:  ".$email." registered:".now();
          $log_type=3;
          Log::create([
              'value'=>$message,
              'logs_type_id'=>$log_type
          ]);
         return response()->json([
             'status'=>'true',
             'message'=>'You sucessfull registred'
         ],201);

      }catch (\Exception $e){
          \Illuminate\Support\Facades\Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
          return response()->json(['error' => $e->getMessage()], );
      }

    }
    public function editProfile(UserEditRequest $request)
    {
    $first_name=$request->input('first_name');
    $last_name=$request->input('last_name');
    $email=$request->input('email');
    $user_id=$request->input('user_id');
    $postoji_slika=$request->hasFile('picture');
    if($postoji_slika)
    $picture_name=$request->file('picture')->getClientOriginalName();
    try{
        if($postoji_slika)$this->cutImage($request,true);
        $user_objekat=User::find($user_id);
        $user_objekat->first_name=$first_name;
        $user_objekat->last_name=$last_name;
        $user_objekat->email=$email;
        if($postoji_slika)$user_objekat->picture=$picture_name;
        $user_objekat->role_id=$user_id;
        $user_objekat->save();
        $user_sesija=User::where('id',$user_id)->first();
        Session::put('user',$user_sesija);
        return redirect()->back();

    }catch (\Exception $e) {
        dd($e->getMessage());

    }

    }
    public function reset_password_index()
    {
        return view('pages.forgot-password');
    }
    public function user_for_reset(Request $request)
    {
        $request->validate([
            "email"=>"required|exists:users,email"
        ]);
        $email=$request->input('email');
        $user_objekat=User::where('email',$email)->first();
        if($user_objekat!=null){
            $code = Str::random(6);
            $user_objekat->reset_code=$code;
            $user_objekat->save();
            $data = [
                'name' => $user_objekat->first_name,
            ];

            Mail::to($user_objekat->email)->send(new RecoverPasswordMail($data,$code));
           return view('pages.2fa_security_form',['user'=>$user_objekat]);
        }

    }
    public function user_check_code(Request $request)
    {
        $request->validate([
            'first_char'=>'required|min:1|max:1',
            'second_char'=>'required|min:1|max:1',
            'third_char'=>'required|min:1|max:1',
            'four_char'=>'required|min:1|max:1',
            'five_char'=>'required|min:1|max:1',
            'six_char'=>'required|min:1|max:1',
        ]);
        $code=$request->input('first_char').$request->input('second_char').$request->input('third_char').$request->input('four_char').$request->input('five_char').$request->input('six_char');
        if($code==null){
            return redirect()->back();
        }
        $user_id=$request->input('user_id');
        $user_objekat=User::find($user_id);
        if($user_objekat->reset_code==$code){
            return view('pages.forgot-password',['user'=>$user_objekat]);
        }
    }
    public function user_update_password(Request $request)
    {
        $request->validate([
            'password' => ['required', Password::min(8)->mixedCase()->symbols()],
            're_password' => 'required|same:password',
        ], [
            'required' => 'Password is required.',
            'password.*' => 'Password is not in good format.',
            're-password.same' => 'Re password must be same as original password',
        ]);
        $password=$request->input('password');
        $user_id=$request->input('user_id');
        $user_objekat=User::where('id',$user_id)->first();
        if($user_objekat==null){
            return redirect()->back();
        }
        $hesovana_sifra=Hash::make($password);
        $user_objekat->password=$hesovana_sifra;
        $user_objekat->save();
        return view('pages.login');


    }

}
