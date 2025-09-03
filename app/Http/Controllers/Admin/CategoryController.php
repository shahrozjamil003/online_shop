<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CategoryRequest;
use App\Models\TemImages;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class CategoryController extends Controller
{
    public function index(Request $request){
        
        $categories = Category::latest();
        if($request->has('keyword') && $request->keyword != ''){
            $categories->where('name', 'LIKE', '%' . $request->keyword . '%');
        }   
        $categories = $categories->paginate(10);
        return view('admin.category.list', compact('categories'));
    }

    
    public function create(){
       return view('admin.category.create');
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ];
        

        if($validator->passes()){
           $category = Category::create($data);

            if(!empty($request->image_id)){
                $temImage = TemImages::find($request->image_id);
                $extArray = explode('.', $temImage->name);
                $ext = last($extArray);
                $newImageName = $category->id.'.'.$ext;
                $sPath = public_path().'/tem/'.$temImage->name;
                $dPath = public_path().'/upload/category/'.$newImageName;
                File::copy($sPath, $dPath);
                $thumbPath = public_path().'/upload/category/thumb/'.$newImageName;
                Image::read($dPath)
                    ->resize(450, 600)
                    ->save($thumbPath);


                $category->image = $newImageName;
                $category->save();
            }

            session()->flash('success', 'Category Added Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Category Added Successfully',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }


    public function edit($id){
        $category = Category::find($id);
        if(empty($category)){
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id){
        $category = Category::find($id);
        $oldImage = $category->image;
        if(empty($category)){
            session()->flash('error', 'Category not found');
            return response()->json([
                'status' => false,
                'not found' => true,
                'message' => 'category not found'
            ]);
        }
         $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:categories,slug,".$category->id.",id",
        ]);

       
        

        if($validator->passes()){
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            if(!empty($request->image_id)){
                $temImage = TemImages::find($request->image_id);
                $extArray = explode('.', $temImage->name);
                $ext = last($extArray);
                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/tem/'.$temImage->name;
                $dPath = public_path().'/upload/category/'.$newImageName;
                File::copy($sPath, $dPath);

                $thumbPath = public_path().'/upload/category/thumb/'.$newImageName;
                Image::read($sPath)
                    ->resize(450, 600)
                    ->save($thumbPath);


                $category->image = $newImageName;
                $category->save();

                
                    File::delete(public_path().'/upload/category/'.$oldImage);
                    File::delete(public_path().'/upload/category/thumb/'.$oldImage);
                
                
            }

            session()->flash('success', 'Category Updated Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Category Not Found Successfully',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy($id, Request $request){
        $record = Category::find($id);
        if(empty($record)){
            session()->flash('error', 'Category Not Found');
            return response()->json([
                'status' => true,
                'message' => 'Category Not Found'
            ]);
        }

        File::delete(public_path().'/upload/category/'.$record->image);
        File::delete(public_path().'/upload/category/thumb/'.$record->image);

        $record->delete();
        
        session()->flash('success', 'Category Deleted Successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted Successfully'
        ]);
    }
}
