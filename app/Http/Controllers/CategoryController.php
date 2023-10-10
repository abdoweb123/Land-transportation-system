<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /*** index function  ***/
    public function index()
    {
        $categories = Category::latest()->paginate(page);
        return view('pages.Categories.index', compact('categories'));
    }



    /*** store function  ***/
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->admin_id = auth('admin')->id();
        $category->active = 1;
        $category->save();
        return redirect()->back()->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** update function  ***/
    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->admin_id = auth('admin')->id();
        $category->active = $request->active;
        $category->update();
        return redirect()->back()->with('alert-info','تم تحديث البيانات بنجاح');
    }



    /*** destroy function  ***/
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('alert-info','تم حذف البيانات بنجاح');
    }

} //end of class
