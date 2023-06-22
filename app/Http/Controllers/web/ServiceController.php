<?php

namespace App\Http\Controllers\web;
use App\Models\Product;
use App\Models\Category;
use App\Models\TableResturant;
use App\Models\ProductService;
use App\Models\TableHotel;
use App\Models\ProductStaff;
use App\Models\TableHHospital;
use App\Models\ProductDetailsImage;
use App\Models\ProductDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index()
    {
         $product = Product::with('media')->get();
        // $category->getFirstMediaUrl();

        return view('product.index', [
            'products' => $product,
            'title' => 'Products',
            'flashMessage' => session('success')
        ]);
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', [
            'product' => $product,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }


    public function store(Request $request)
    {
        //dd($request->photo);
        $rules = [
            'name'          => ['unique:categories,name', 'required', 'string', 'min:3'],
            'discription'   => ['nullable', 'string'],
            'category_id'   => [ 'nullable','int', 'exists:categories,id'],
            'photo'         => ['nullable', 'image'],
        ];

        $validator = $request->validate($rules);
        $product = new Product();
        $product->name        = $request->name;
        $product->discription = $request->discription;
        $product->category_id = $request->category_id;
        $product->govern_id   = $request->govern_id;
        $product->region_id   = $request->region_id;
        
        //$product->addMedia($request->photo)->toMediaCollection();
        $file = $request->photo;
        $filename = $file->getClientOriginalName();
        $file->move('images/products/', $filename);
        $product->photo = $filename;

        $product->save();
        // PRG : Post Redirect Get
        return redirect('/products')->with('success','Product Created!');
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name'          => ['required', 'string', 'min:3'],
            'discription'   => ['nullable', 'string'],
            'category_id'   => ['nullable', 'int', 'exists:categories,id'],
            'photo'         => ['nullable', 'image'],
        ];

        $validator = $request->validate($rules);
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->discription = $request->input('discription');
        $product->category_id = $request->input('category_id');
        $product->govern_id   = $request->govern_id;
        $product->region_id   = $request->region_id;
        if ($request->photo) 
        {
            if (File::exists('images/products/' .$product->photo)) 
            {
                File::delete('images/products/'.$product->photo);
            }
            $file = $request->photo;
            $filename = $file->getClientOriginalName();
            $file->move('images/products/', $filename);
            $product->photo = $filename;
            //$product->addMedia($request->photo)->toMediaCollection();
        }

        $product->save();
        return redirect('/products')->with('success', 'Product Updated!');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/products')->with('success', 'Product deleted!');
    }

    public function getregions($id)
    {
        $list_region = Region::where("govern_id", $id)->pluck("name", "id");
        return $list_region;
    }

    public function details($id)
    {
        $product = Product::find($id);
        $productdetails = ProductDetails::where('product_id',$id)->first();

        if($productdetails)
        {
            return view('product.details',compact('product','productdetails'));
        }
        else
        {
            return view('product.details2',compact('product'));
        }
        
    }

    public function adddetails(Request $request,$product_id)
    {
        //dd($request);
        try
        {
            $request->validate(
                                [
                                    'name' => 'required',
                                    'email' => 'required',
                                    'phone' => 'required',
                                    'discription' => 'required',
                                    'location' => 'required',
                                    'mission' => 'required',
                                    'vision' => 'required',
                                    'about' => 'required',
                                    'product_id' => 'required',
                                ]
                            );
            $productdetails = ProductDetails::where('product_id',$product_id)->first();
            $productdetails->name = $request->name;
            $productdetails->email = $request->email;
            $productdetails->phone = $request->phone;
            $productdetails->desc = $request->discription;
            $productdetails->location = $request->location;
            $productdetails->mission = $request->mission;
            $productdetails->vision = $request->vision;
            $productdetails->about = $request->about;
            $productdetails->product_id = $request->product_id;
            
            if($request->file('image'))
            {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $file->move('images/products/details', $filename);
                $productdetails->image = $filename;
            }

            if($request->file('images'))
            {
                $pkgimage = ProductDetailsImage::where('product_id', $product_id)->get();
                foreach($pkgimage as $image)
                {
                    $image->delete();
                    if (File::exists('images/products/details/' .$image->image)) 
                    {
                        File::delete('images/products/details/'.$image->image);
                    }
                }
                foreach ($request->file('images') as $image) 
                {
                    $productimage = new ProductDetailsImage();
    
                    $productimage->product_id = $product_id;
    
                    $file = $image;
                    $filename = $file->getClientOriginalName();
                    $file->move('images/products/details', $filename);
                    $productimage->image = $filename;
                    
                    $productimage->save();
                }
            }
            $productdetails->save();

            if($request->kt_docs_repeater_basic1)
            {
                foreach($request->kt_docs_repeater_basic1 as $service)
                {
                    $productservice = new ProductService();
                    $productservice->name = $service['nameservice'];
                    $productservice->description = $service['descservice'];
                    $productservice->product_id = $product_id;
                    $productservice->save();
                }
            }

            if($request->kt_docs_repeater_basic)
            {
                foreach($request->kt_docs_repeater_basic as $staff)
                {
                    $productstaff = new ProductStaff();
                    $productstaff->name = $staff['namestaff'];
                    $productstaff->title = $staff['titlestaff'];

                    $file = $staff['imgestaff'];
                    $filename = $file->getClientOriginalName();
                    $file->move('images/products/staff', $filename);
                    $productstaff->image = $filename;
                    $productstaff->product_id = $product_id;
                    $productstaff->save();
                }
            }

            return redirect()->route('product.index')->with('success', 'Product detailes added!');
        }
        catch (\Exception $e) 
        {
            return response()->json(['err' => true, 'msg' => $e->getMessage()], 404);
        }

    }

    public function adddetails2(Request $request,$product_id)
    {
        try
        {
            $request->validate(
                                [
                                    'name' => 'required',
                                    'email' => 'required',
                                    'phone' => 'required',
                                    'discription' => 'required',
                                    'location' => 'required',
                               
                                    'mission' => 'required',
                                    'vision' => 'required',
                                    'about' => 'required',
                                    'product_id' => 'required',
                                    //'staff	' => 'required',
                                ]
                            );
            $productdetails = new ProductDetails();
            $productdetails->name = $request->name;
            $productdetails->email = $request->email;
            $productdetails->phone = $request->phone;
            $productdetails->desc = $request->discription;
            $productdetails->location = $request->location;
        
            $productdetails->mission = $request->mission;
            $productdetails->vision = $request->vision;
            $productdetails->about = $request->about;
            $productdetails->product_id = $request->product_id;
   
            
            if($request->file('image'))
            {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $file->move('images/products/details', $filename);
                $productdetails->image = $filename;
            }
            if($request->file('images'))
            {
                $pkgimage = ProductDetailsImage::where('product_id', $product_id)->get();

                foreach($pkgimage as $image)
                {
                    $image->delete();
                    if (File::exists('images/products/details/' .$image->image)) 
                    {
                        File::delete('images/products/details/'.$image->image);
                    }
                }
                foreach ($request->file('images') as $image) 
                {
                    $productimage = new ProductDetailsImage();

                    $productimage->product_id = $product_id;

                    $file = $image;
                    $filename = $file->getClientOriginalName();
                    $file->move('images/products/details', $filename);
                    $productimage->image = $filename;
                    
                    $productimage->save();
                }
            }

            $productdetails->save();
 if($request->kt_docs_repeater_basic1)
            {
                foreach($request->kt_docs_repeater_basic1 as $service)
                {
                    $productservice = new ProductService();
                    $productservice->name = $service['nameservice'];
                    $productservice->description = $service['descservice'];
                    $productservice->product_id = $product_id;
                    $productservice->save();
                }
            }

            if($request->kt_docs_repeater_basic)
            {
                foreach($request->kt_docs_repeater_basic as $staff)
                {
                    $productstaff = new ProductStaff();
                    $productstaff->name = $staff['namestaff'];
                    $productstaff->title = $staff['titlestaff'];

                    $file = $staff['imgestaff'];
                    $filename = $file->getClientOriginalName();
                    $file->move('images/products/staff', $filename);
                    $productstaff->image = $filename;
                    $productstaff->product_id = $product_id;
                    $productstaff->save();
                }
            }
            return redirect()->route('product.index')->with('success', 'Product detailes added!');
        }
        catch (\Exception $e) 
        {
            return response()->json(['err' => true, 'msg' => $e->getMessage()], 404);
        }

    }

    public function data($id)
    {
        $product = Product::find($id);
        if($product->category_id === 1)
        {
            $tableresturant = TableResturant::where('product_id',$id)->get();
            
            if($tableresturant)
            {
                $count = $tableresturant->count();
                return view('product.data12',compact('product','count'));
            }
            else
            {
                return view('product.data1',compact('product'));
            }
        }
        elseif($product->category_id === 2)
        {
            $tableresturant = TableHotel::where('product_id',$id)->get();
            if($tableresturant)
            {
                $count = $tableresturant->count();
                return view('product.data22',compact('product','count'));
            }
            else
            {
                return view('product.data2',compact('product'));
            }  
        }
        else
        {
            $tableresturant = TableHHospital::where('product_id',$id)->get();

            if($tableresturant)
            {
                $tableresturant1 = TableHHospital::where('product_id',$id)->where('type','operation')->get()->count();
                $tableresturant2 = TableHHospital::where('product_id',$id)->where('type','medica')->get()->count();
                return view('product.data23',compact('product','tableresturant1','tableresturant2'));
            }
            else
            {
                return view('product.data3',compact('product'));
            }  
        }
    }

    public function data1(Request $request,$product_id)
    {
        for($i=1;$i<=$request->table;$i++)
        {
            $table = new TableResturant();
            $table->table = $i;
            $table->product_id = $product_id;
            $table->save();
        }
        return redirect()->route('product.index')->with('success', 'Product data added!');
    }

    public function data2(Request $request,$product_id)
    {
        for($i=1;$i<=$request->rooms;$i++)
        {
            $table = new TableHotel();
            $table->room = $i;
            $table->product_id = $product_id;
            $table->save();
        }
        return redirect()->route('product.index')->with('success', 'Product data added!');
    }

    public function data3(Request $request,$product_id)
    {
        for($i=1;$i<=$request->opertion;$i++)
        {
            $table = new TableHHospital();
            $table->type = 'operation';
            $table->product_id = $product_id;
            $table->save();
        }

        for($i=1;$i<=$request->medical;$i++)
        {
            $table = new TableHHospital();
            $table->type = 'medica';
            $table->product_id = $product_id;
            $table->save();
        }
        return redirect()->route('product.index')->with('success', 'Product data added!');
    }

    public function data11(Request $request,$product_id)
    {
        $table = TableResturant::where('product_id',$product_id)->delete();
        for($i=1;$i<=$request->table;$i++)
        {
            $table = new TableResturant();
            $table->table = $i;
            $table->product_id = $product_id;
            $table->save();
        }
        return redirect()->route('product.index')->with('success', 'Product data added!');
    }

    public function data22(Request $request,$product_id)
    {
        $table = TableHotel::where('product_id',$product_id)->delete();
        // foreach()
        for($i=1;$i<=$request->rooms;$i++)
        {
            $table = new TableHotel();
            $table->room = $i;
            $table->product_id = $product_id;
            $table->save();
        }
        return redirect()->route('product.index')->with('success', 'Product data added!');
    }

    public function data33(Request $request,$product_id)
    {
        $table = TableHHospital::where('product_id',$product_id)->delete();
        for($i=1;$i<=$request->opertion;$i++)
        {
            $table = new TableHHospital();
            $table->type = 'operation';
            $table->product_id = $product_id;
            $table->save();
        }

        for($i=1;$i<=$request->medical;$i++)
        {
            $table = new TableHHospital();
            $table->type = 'medica';
            $table->product_id = $product_id;
            $table->save();
        }
        return redirect()->route('product.index')->with('success', 'Product data added!');
    }
}
