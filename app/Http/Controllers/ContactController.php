<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request)
    {
        try{


            return response()->json([
                'success'=>"Successfully sent message to administrator. Administrator will ansver you in a few hours!"
            ]);
        }
        catch (\Exception $e){
            Log::error('Greška prilikom izvršavanja: ' . $e->getMessage());
            return response()->json([
                'error'=>$e->getMessage()
            ]);
        }
    }

}
