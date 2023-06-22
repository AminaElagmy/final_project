<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $product->save();

        $product->addMedia($request->photo)->toMediaCollection();

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
        if ($request->photo) {
            $product->addMedia($request->photo)->toMediaCollection();
        }

        $product->save();
        return redirect('/products')->with('success', 'Product Updated!');
    }


    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/products')->with('success', 'Product deleted!');
}
}
