<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function create(){
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brands::orderBy('name', 'ASC')->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request){
        $rules = [
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'sku' => 'required',
            'track_qty' => 'required|in:yes,no',
            'category' => 'required',
            'is_featured' => 'required|in:yes,no'
        ];

        if(! empty($request->track_qty) && $request->track_qty == 'yes'){
            $rules['qty'] = 'required|numeric';
        }

       $validator = Validator::make($request->all(), $rules);

       if($validator->passes()){
            Product::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'price' => $request->price,
                'compare_price' => $request->compare_price,
                'sku' => $request->sku,
                'barcode' => $request->barcode,
                'track_qty' => $request->track_qty,
                'qty' => $request->qty,
                'status' => $request->status,
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
                'brand_id' => $request->brand,
                'is_featured' => $request->is_featured

            ]);
                session()->flash('success', 'New Product Created Successfully');
                return response()->json([
                    'status' => true,
                    'message' => 'New Product Created Successfully'
            ]);
       }else{
            return response()->json([
                'status' =>  false,
                'errors' => $validator->errors()
            ]);
       }
    }








    public function getsubcategory(Request $request){
        if(! empty($request->category_id)){
            $subcategories = SubCategory::where('category_id', $request->category_id)
            ->orderBy('name', 'ASC')
            ->get();

            return response()->json([
                'status' => true,
                'subcategories' => $subcategories
            ]);
        }else{
            return response()->json([
                'status' => false,
                'subcategories' => []
            ]);
        }
    }
}
