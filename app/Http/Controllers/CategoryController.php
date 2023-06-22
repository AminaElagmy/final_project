<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
         $category = Category::with('media')->get();
        // $category->getFirstMediaUrl();

        return view('category.index', [
            'categories' => $category,
            'title' => 'Categories',
            'flashMessage' => session('success')
        ]);
    }


    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('category.show', [
            'category' => $category,
        ]);
    }

    public function create()
    {
        $parents = Category::all();
        return view('category.create', compact('parents'));
    }


    public function store(Request $request)
    {
        $rules = [
            'name'          => ['unique:categories,name', 'required', 'string', 'min:3'],
            'discription'   => ['nullable', 'string'],
            'parent_id'     => ['nullable', 'int', 'exists:categories,id'],
            'photo'         => ['nullable', 'image'],
        ];

        $validator = $request->validate($rules);
        $category = new Category();
        $category->name        = $request->name;
        $category->discription = $request->discription;
        $category->parent_id   = $request->parent_id;
        $category->save();

        $category->addMedia($request->photo)->toMediaCollection();

        // PRG : Post Redirect Get
        return redirect('/categories')->with('success','Category Created!');
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::all();
        return view('category.edit', compact('category', 'parents'));
    }


    public function update(Request $request, $id)
    {

        $rules = [
            'name'          => ['required', 'string', 'min:3'],
            'discription'   => ['nullable', 'string'],
            'parent_id'     => ['nullable', 'int', 'exists:categories,id'],
            'photo'         => ['nullable', 'image'],
        ];

        $validator = $request->validate($rules);
        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->discription = $request->input('discription');
        $category->parent_id = $request->input('parent_id');
        if ($request->photo) {
            $category->addMedia($request->photo)->toMediaCollection();
        }

        $category->save();
        return redirect('/categories')->with('success', 'Category Updated!');
    }


    public function destroy($id)
    {
        Category::destroy($id);
        return redirect('/categories')->with('success', 'Category deleted!');
    }
}
