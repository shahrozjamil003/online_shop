<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandsController extends Controller
{

    public function index(Request $request){
        $brands = Brands::latest('id')->paginate(10);
        if($request->has('keyword')){
            $brands = Brands::where('name', 'LIKE', '%'. $request->keyword .'%')->paginate(10);
        }
        return view('admin.brands.list', compact('brands'));
    }


    public function create(){
        return view('admin.brands.create');
    }

    public function store(Request $request){
       
       $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'required'
        ]);

        if($validator->passes()){
            Brands::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status
            ]);

            session()->flash('success', 'New Brand Created Successfully');
            return response()->json([
                'status' => true,
                'message' => 'New Brand Created Successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit($id){
        $brands = Brands::find($id);
        if(empty($brands)){
            return redirect()->route('brand.index');
        }
        return view('admin.brands.edit', compact('brands'));
    }

    public function update(Request $request,  $id){
        $brand = Brands::find($id);
         if(empty($brand)){
         session()->flash('error', 'Brand Not Found');
         
         return response()->json([
            'status' => false,
            'not found' => true
         ]);
      }

      $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'. $request->id .',id',
            'status' => 'required'
      ]);

      if($validator->passes()){
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            session()->flash('success', 'Brand Has Successfully Editted');

            return response()->json([
                'status' => true,
                'message' => 'Brand Has Successfully Editted'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id){
        $brand = Brands::find($id);
        if(empty($brand)){
            session()->flash('error', 'Brand Not Found');

            return response()->json([
                'status' => false,
                'not found' => true
            ]);
        }

        $brand->delete();

        session()->flash('success', 'Brand Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => 'brand Deleted Successfully'
        ]);
    }
}
