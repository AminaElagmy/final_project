<?php

namespace App\Http\Controllers;
use App\Models\Governorate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GovernmentController extends Controller
{
    public function index()
    {
        $governments = Governorate::all();
        return $governments;
    }

    public function create(Request $request)
    {   
        $request->validate(
            [
                'name' => 'required',
            ]
        );
        $governorate = new Governorate();
        $governorate->name = $request->name;
        $governorate->save();
        return response()->json(['success' => true,'governorate' => $governorate], 200);
    } 
}
