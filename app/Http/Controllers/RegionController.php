<?php

namespace App\Http\Controllers;
use App\Models\Region;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index($id)
    {
        $regions = Region::where('govern_id',$id)->get();
        return $regions;
    }

    public function create(Request $request)
    {   
        $request->validate(
            [
                'name' => 'required',
                'govern_id' => 'required',
            ]
        );
        $region = new Region();
        $region->name = $request->name;
        $region->govern_id = $request->govern_id;
        $region->save();
        return response()->json(['success' => true,'governorate' => $region], 200);
    } 
}
