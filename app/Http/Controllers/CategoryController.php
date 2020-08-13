<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $sub_category_array = [];
        foreach ($categories as $category) {
            $sub_categories = SubCategory::where('category_id', $category->id)->get();
            $sub_category_array[$category->id] = $sub_categories;
        }
        return view('categories.index', compact('categories', 'sub_category_array'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $category = Category::create($validatedData);
        if ($category->save()) {
            $categories = Category::all();
            return redirect()->route('categories.index', compact('categories'))->with('success', $category->name . ' has been added successfully.');
        } else {
            return back()->with('error', 'Category has not been added.');

        }

    }

    public function show($id)
    {
        return view('categories.show');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);
        $category = Category::find($id);
        $category->name = $request->input('name');
        if ($category->save()) {
            return redirect()->route('categories.index')->with('success', 'Category title has been updated.');
        } else {
            return back()->with('error', 'Category title has not been updated.');
        }
    }

    public function destroy($id)
    {
        DB::table('sub_categories')->where('category_id', $id)->delete();
        DB::table('categories')->where('id', $id)->delete();

        return back()->with('success', 'Category and its sub categories has been deleted successfully.');
    }
}
