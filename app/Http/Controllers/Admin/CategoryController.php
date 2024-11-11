<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index(){
        $pageTitle = 'All Categories';
        $categories = Category::orderBy('id','desc')->paginate(getPaginate(12));
        return view('admin.category.index',compact('categories','pageTitle'));
     }


    public function store(Request $request)
{
        $request->validate([
            'name' => 'required|max:191|unique:categories',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->status = 1;
        $category->save();

        return response()->json([
            'message' => 'Category has been created successfully',
            'category' => $category,
        ]);

}

     public function update(Request $request){
        $request->validate([
            'name' => 'required|max:190',
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->status = $request->status ? 1 : 0;
        $category->save();

        return response()->json([
            'message' => 'Category has been updated successfully',
            'category' => $category,
        ]);

     }
}
