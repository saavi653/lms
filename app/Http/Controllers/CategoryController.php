<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    { 
        $categories=Category::Search(request([
            'search',
            'sort'
        
        ]));
        $categories = $categories->visible()->get();
    
        return view('category.index', ['categories'=>$categories]);  
    }
    public function create()
    {

        return view('category.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
                'name' => 'string|min:3|max:255|required'
            ]);
            
            $attributes += [
                'created_by' => Auth::id()
            ];
            
            $restore=Category::where('name',$request->name)->withTrashed()->First();
            // dd($restore->deleted_at);
            if($restore!=null)
            {
                if($restore->deleted_at)
                {
                    $restore->restore();
                    return redirect()->route('categories.index')
                        ->with('success','category restored successfully');
                }
            }
            Category::create($attributes);

            return redirect()->route('categories.index')
                ->with('success','category created successfully');
    }
    public function edit(Category $category)
    {
        return view('category.edit', [
            'category' => $category
            ]);
    } 
    public function update(Request $request, Category $category){
        $data=$request->validate(
            [
                'name' => 'required|min:3|max:255|string'
            ]);
        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success','category updated successfully');
    }
    public function delete(Category $category)
    {
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success','category deleted successfully');
    } 

    public function status(Category $category) {   
        if($category->status)
        {  
            $temp =['status'=> 0];
            $category->update($temp);   
        }
        else
        {     
           $temp =['status'=>1];
            $category->update($temp);  
        }

        return redirect()->route('categories.index');
   }
}
