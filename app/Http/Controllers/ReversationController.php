<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\ReservationHotel;
use App\Models\ReservationHospital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ReversationController extends Controller
{
    public function reversetable(Request $request)
    {
        try
        {
            $request->validate(
                [
                    'product_id' => 'required',
                    'item_id' => 'required',
                ]
            );
            $reverse = new Reservation();
            $reverse->user_id = Auth::user()->id;
            $reverse->product_id = $request->product_id;
            $reverse->item_id = $request->item_id;
            $reverse->save();
            return response()->json(['success' => true,'data' => $reverse], 200); 
        }
        catch (\Exception $e) 
        {
            return response()->json(['err' => true, 'msg' => $e->getMessage()], 404);
        }
        
    }

    public function reverseroom(Request $request)
    {
        try
        {
            $request->validate(
                [
                    'product_id' => 'required',
                    'item_id' => 'required',
                ]
            );
            $reverse = new ReservationHotel();
            $reverse->user_id = Auth::user()->id;
            $reverse->product_id = $request->product_id;
            $reverse->item_id = $request->item_id;
            $reverse->save();
            return response()->json(['success' => true,'data' => $reverse], 200); 
        }
        catch (\Exception $e) 
        {
            return response()->json(['err' => true, 'msg' => $e->getMessage()], 404);
        }
        
    }
    public function reverseoperation(Request $request)
    {
        try
        {
            $request->validate(
                [
                    'product_id' => 'required',
                    'item_id' => 'required',
                    'type' => 'required',
                ]
            );
            $reverse = new ReservationHospital();
            $reverse->user_id = Auth::user()->id;
            $reverse->product_id = $request->product_id;
            $reverse->item_id = $request->item_id;
            $reverse->type = $request->type;
            $reverse->save();
            return response()->json(['success' => true,'data' => $reverse], 200); 
        }
        catch (\Exception $e) 
        {
            return response()->json(['err' => true, 'msg' => $e->getMessage()], 404);
        }
        
    }
}
