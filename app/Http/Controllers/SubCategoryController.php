<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    public function index()
    {
//        $sub_categories = SubCategory::all();
//        $categories_array = [];
//        foreach ($sub_categories as $sub_category) {
//            $category = Category::find($sub_category->category_id);
//            $categories_array[$sub_category->id] = $category;
//        }
//        $categories = Category::all();
//        return view('sub_categories.index', compact('sub_categories', 'categories', 'categories_array'));
    }

    public function create()
    {
//        $categories = Category::all();
//        return view('sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
        ]);


        $name = $request->input('name');
        $category_id = $request->input('category_id');

        $sub_category = SubCategory::where('name', $name)->where('category_id', $category_id)->first();

        if ($sub_category != null) {
            $category = Category::find($sub_category->category_id);

            return back()->with('error', $name . ' already exists for ' . $category->name . '.');
        }

        $category = SubCategory::create([
            'name' => ucwords($name),
            'category_id' => $category_id,
        ]);
        if ($category->save()) {

            return back()->with('success', $category->name . ' has been added successfully.');
        } else {
            return back()->with('error', 'Subcategory has not been added.');

        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
        ]);


        $name = $request->input('name');
        $category_id = $request->input('category_id');

        $sub_category = SubCategory::find($id);
        $sub_category->name = ucwords($name);
        $sub_category->category_id = $category_id;

        if ($sub_category->save()) {

            return back()->with('success', $sub_category->name . ' has been updated successfully.');
        } else {
            return back()->with('error', 'Sub category has not been added.');

        }
    }

    public function destroy($id)
    {
        SubCategory::find($id)->delete();
        return back()->with('success', 'Sub category has been deleted successfully.');
    }
}
