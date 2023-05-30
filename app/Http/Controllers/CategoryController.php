<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Rule;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    public function allCategories()
{
    $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
    return view('all-category', compact('categories'));
}

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('category_id');
        $subcategories = Category::where('parent_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function createCategory(Request $request)
    {
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
    
        if ($request->method() == 'GET') {
            // Pass only the $categories variable to the view
            return view('create-category', compact('categories'));
        }
    
        if ($request->method() == 'POST') {
            $validator = $request->validate([
                'name' => 'required',
                // 'slug' => 'required|unique:categories',
                'parent_id' => 'nullable|numeric'
            ]);
    
            Category::create([
                'name' => $request->name,
                // 'slug' => $request->slug,
                'parent_id' => $request->parent_id
            ]);

            return redirect()->back()->with('success', 'Category has been created successfully.');
        }
    }

    public function editCategory($id, Request $request)
    {
        $category = Category::findOrFail($id);
        if($request->method()=='GET')
        {
            $categories = Category::where('parent_id', null)->where('id', '!=', $category->id)->orderby('name', 'asc')->get();
            return view('edit-category', compact('category', 'categories'));
        }

        if($request->method()=='POST')
        {
            $validator = $request->validate([
                'name'     => 'required',
                // 'slug' => ['required', Rule::unique('categories')->ignore($category->id)],
                'parent_id'=> 'nullable|numeric'
            ]);
            if($request->name != $category->name || $request->parent_id != $category->parent_id)
            {
                if(isset($request->parent_id))
                {
                    $checkDuplicate = Category::where('name', $request->name)->where('parent_id', $request->parent_id)->first();
                    if($checkDuplicate)
                    {
                        return redirect()->back()->with('error', 'Category already exist in this parent.');
                    }
                }
                else
                {
                    $checkDuplicate = Category::where('name', $request->name)->where('parent_id', null)->first();
                    if($checkDuplicate)
                    {
                        return redirect()->back()->with('error', 'Category already exist with this name.');
                    }
                }
            }

            $category->name = $request->name;
            $category->parent_id = $request->parent_id;
            $category->save();
            return redirect()->back()->with('success', 'Category has been updated successfully.');
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        if (count($category->subcategory)) {
            $subcategories = $category->subcategory;
            foreach ($subcategories as $cat) {
                $this->deleteSubcategories($cat);
            }
        }
        $category->delete();
        return redirect()->back()->with('delete', 'Category and its subcategories have been deleted successfully.');
    }
    
    private function deleteSubcategories($category)
    {
        if (count($category->subcategory)) {
            $subcategories = $category->subcategory;
            foreach ($subcategories as $cat) {
                $this->deleteSubcategories($cat);
            }
        }
        $category->delete();
    }
    

}
