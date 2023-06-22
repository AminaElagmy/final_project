<?php

namespace App\Http\Controllers\api;
use App\Http\Resources\ServiceResource;
use App\Models\Product;
use App\Models\Category;
use App\Models\TableHotel;
use App\Models\Region;
use App\Models\Reservation;
use App\Models\User;
use App\Models\ProductDetailsImage;
use App\Models\TableResturant;
use App\Models\ReservationHospital;
use App\Models\ProductStaff;
use App\Models\ReservationHotel;
use App\Models\TableHHospital;
use App\Models\ProductService;
use App\Models\ProductDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ServiceController extends Controller
{
    public function show()
    {
         $products=Product::get();
         $products = ServiceResource::collection($products);

         return response()->json([
            'status' => 201,
            'data'   => $products,
        ], 201);
    }

    public function allCategory()
    {
        $cats = Category::all();
        foreach($cats as $cat)
        {
            $cat->photo = url('images/category/'.$cat->photo);
        }
        return response()->json(['status' => 201,'data' => $cats], 201);
    }

    public function allProductForCat($id)
    {
        $products = Product::where('category_id',$id)->get();
        foreach($products as $product)
        {
            $product->photo = url('images/products/'.$product->photo);
        }
        return response()->json(['status' => 201,'data' => $products], 201);
    }

    public function search(Request $request)
    {
        $product = Product::where('name',$request->name)->first();
        $product->photo = url('images/products/'.$product);
        return response()->json(['status' => 201,'data' => $product], 201); 
    }

    public function filter($cat,$govrn_id)
    {
        $products = Product::where('govern_id',$govrn_id)->where('category_id',$cat)->get();
        foreach($products  as  $product)
        {
            $product->photo = url('images/products/'.$product->photo);
        }
        return response()->json(['success' => true,'data' => $products], 200); 
    }

    public function filtergovernmentRegion($cat,$govrn_id,$region_id)
    {
        $products = Product::where('govern_id',$govrn_id)->where('region_id',$region_id)->where('category_id',$cat)->get();
foreach($products  as  $product)
        {
            $product->photo = url('images/products/'.$product->photo);
        }
        return response()->json(['success' => true,'data' => $products], 200); 
    }


 public function getOneProduct($id)
    {
        $product = Product::find($id);
        $product->photo = url('images/products/'.$product->photo);

        $proddetailsimages = ProductDetailsImage::where('product_id',$product->id)->get();
if($proddetailsimages)
{
foreach($proddetailsimages as $proddetailsimage)
        {
            $proddetailsimage->image = url('images/products/details/'.$proddetailsimage->image);
        }
}
        
        $product->images = $proddetailsimages;
        $proddetails = ProductDetails::where('product_id',$product->id)->first();
if($proddetails)
{
$proddetails->image = url('images/products/details/'.$proddetails->image);
      
}
        
  $product->details = $proddetails;
        $prodstaffs = ProductStaff::where('product_id',$product->id)->get();

        if(count($prodstaffs) >0)
        {
            foreach($prodstaffs as $prodstaff)
            {
                $prodstaff->image = url('images/products/staff/'.$prodstaff->image);
            }
            $product->prodstaffs  = $prodstaffs;
        }
        else
        {
            $product->prodstaffs  = $prodstaffs;
        }
        
        $prodservice = ProductService::where('product_id',$product->id)->get();
        $product->prodservice  = $prodservice;

        if($product->category_id == 1)
        {
            $prodtables1 = TableResturant::where('product_id',$product->id)->get();
            foreach($prodtables1 as $pt1)
            {
                $pt1->reserve = Reservation::where('product_id',$product->id)->where('item_id',$pt1->id)->first();
                $pt1->user = User::select('name')->where('id',Auth::user()->id)->first();
            }
            $prodtables = $prodtables1->count();
            $product->prodtables  = $prodtables;
            $product->reserve  = $prodtables1;

        }
        elseif($product->category_id == 2)
        {
            $prodtables1 = TableHotel::where('product_id',$product->id)->get();
            foreach($prodtables1 as $pt1)
            {
                $pt1->reserve = ReservationHotel::where('product_id',$product->id)->where('item_id',$pt1->id)->first();
                $pt1->user = User::select('name')->where('id',Auth::user()->id)->first();
        
            }
            $prodtables = $prodtables1->count();
            $product->prodrooms  = $prodtables;
            $product->reserve  = $prodtables1;
        }
        else
        {
            $prodtablesmedical = TableHHospital::where('product_id',$product->id)->where('type','medica')->get();
            $prodtables1 = $prodtablesmedical->count();
            $prodtablesoperation = TableHHospital::where('product_id',$product->id)->where('type','operation')->get();
            $prodtables2 = $prodtablesoperation->count();
            foreach($prodtablesmedical as $pt1)
            {
                $pt1->reserve = ReservationHospital::where('product_id',$product->id)->where('item_id',$pt1->id)->first();
                $pt1->user = User::select('name')->where('id',Auth::user()->id)->first();
        
            }
            foreach($prodtablesoperation as $pt1)
            {
                $pt1->reserve = ReservationHospital::where('product_id',$product->id)->where('item_id',$pt1->id)->first();
                $pt1->user = User::select('name')->where('id',Auth::user()->id)->first();
        
            }
            $product->reservemedical  = $prodtablesmedical;
            $product->reserveperation  = $prodtablesoperation;
            $product->prodmedical  = $prodtables1;
            $product->prodoperation  = $prodtables2;
        }

        return response()->json(['success' => true,'data' => $product], 200); 
    }
    
}
