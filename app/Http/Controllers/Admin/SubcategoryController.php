<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{

   public function index(Request $request){
      $keyword = $request->keyword;
      $sub_categories = SubCategory::latest('id')->with('category')->get();
      
      if(!empty($keyword)){
        $sub_categories = SubCategory::where('name', 'LIKE', '%' . $keyword . '%')->with('category')->get();
      }
      

      return view('admin.sub_category.list', compact('sub_categories'));
   }

   public function create(){
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.sub_category.create', compact('categories'));
   }

   public function store(Request $request){
      
      $validator = Validator::make($request->all(), [
         'name' => 'required',
         'slug' => 'required|unique:sub_categories,slug',
         'status' => 'required',
         'category' => 'required'
      ]);
      
      if($validator->passes()){

         $subCategory = SubCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'category_id' => $request->category,
         ]);

         session()->flash('success', 'Sub Category Created Successfully');

            return response()->json([
               'status' => true,
               'message' => 'Sub Category Created Successfully'
            ]);
      }
      else{
         return response()->json([
            'status' => false,
            'errors' => $validator->errors() 
         ]);
      }
   }

   public function edit($id){
      
      $sub_category = SubCategory::find($id);
      if(empty($sub_category)){
         session()->flash('error', 'Sub Category Not Found');
         return redirect()->route('sub-categories.index');
      }
      $categories = Category::orderBy('name', 'asc')->get();
      return view('admin.sub_category.edit', compact('sub_category', 'categories'));
   }

   public function update(Request $request, $id){

      $sub_category = SubCategory::find($id);
      if(empty($sub_category)){
         session()->flash('error', 'Sub Category Not Found');
         
         return response()->json([
            'status' => false,
            'not found' => true
         ]);
      }

       $validator = Validator::make($request->all(), [
         'name' => 'required',
         'slug' => 'required|unique:sub_categories,slug,'.$sub_category->id.',id',
         'status' => 'required',
         'category' => 'required'
      ]);
      
      if($validator->passes()){

            $sub_category->name = $request->name;
            $sub_category->slug = $request->slug;
            $sub_category->status = $request->status;
            $sub_category->category_id = $request->category;
            $sub_category->save();

         // $subCategory = SubCategory::create([
         //    'name' => $request->name,
         //    'slug' => $request->slug,
         //    'status' => $request->status,
         //    'category_id' => $request->category,
         // ]);

         session()->flash('success', 'Sub Category Edited Successfully');

            return response()->json([
               'status' => true,
               'message' => 'Sub Category Edited Successfully'
            ]);
      }
      else{
         return response()->json([
            'status' => false,
            'errors' => $validator->errors() 
         ]);
      }
   }

   public function destroy($id){
        $sub_category = SubCategory::find($id);
        if(empty($sub_category)){
            session()->flash('error', 'Sub Category Not Found');
            return response()->json([
                'status' => true,
                'message' => 'Category Not Found'
            ]);
        }

        $sub_category->delete();
        
        session()->flash('success', 'SubCategory Deleted Successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted Successfully'
        ]);
    }
   
}
