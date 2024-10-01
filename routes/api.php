<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/cars',[Controllers\CarsController::class,'index'])->name('cars');
Route::get('/car/{id}',[Controllers\CarsController::class,'getCarWithId'])->name('car_id');
Route::get('/carfilter/filter',[Controllers\CarsController::class,'getCarsAndFilterCars'])->name('getCarFilterCar');
Route::get('/getModel/{id}',[Controllers\CarsController::class,'getModel']);
Route::post('/contact',[Controllers\ContactController::class,'store'])->name('checkMessage');
Route::post("/login",[Controllers\UserController::class,'login'])->name('login.login');
Route::post('/register',[Controllers\UserController::class,'register'])->name('register.register');
Route::get('/user',[Controllers\UserController::class,'index'])->name('user');
Route::post("/order",[Controllers\OrderController::class,'order_store'])->name('order_store');
Route::patch("/order",[Controllers\OrderController::class,'order_change_status'])->name('order_store');


///adminn

Route::apiResource('/users',Controllers\AdminUserController::class);
Route::get("/createusers",[Controllers\AdminUserController::class,'getP']);
Route::get("/updateusers/{id}",[Controllers\AdminUserController::class,'edit']);
Route::post("/updateusers/{id}",[Controllers\AdminUserController::class,'update']);
Route::apiResource('/brands',Controllers\AdminBrandsController::class);
Route::get("/updatebrands/{id}",[Controllers\AdminBrandsController::class,'edit']);
Route::apiResource('/vehicles',Controllers\AdminVehicleController::class);
Route::get("/createvehicles",[Controllers\AdminVehicleController::class,'getP']);
Route::get("/updatevehicles/{id}",[Controllers\AdminVehicleController::class,'edit']);
Route::post("/updatevehicles/{id}",[Controllers\AdminVehicleController::class,'update']);
Route::apiResource('/vehiclePrice',Controllers\AdminVehiclePriceController::class);
Route::get("/createvehiclePrice",[Controllers\AdminVehiclePriceController::class,'getP']);
Route::get("/updatevehiclePrice/{id}",[Controllers\AdminVehiclePriceController::class,'edit']);
Route::apiResource('/models',Controllers\AdminModelResource::class);
Route::get("/createmodels",[Controllers\AdminModelResource::class,'getP']);
Route::get("/updatemodels/{id}",[Controllers\AdminModelResource::class,'edit']);
Route::apiResource('/roles',Controllers\AdminRoleController::class);
Route::get("/updateroles/{id}",[Controllers\AdminRoleController::class,'edit']);
