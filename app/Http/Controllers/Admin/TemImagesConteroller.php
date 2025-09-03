<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TemImages;
use Illuminate\Http\Request;

class TemImagesConteroller extends Controller
{
    public function create(Request $request){
        
        $images = $request->image;
        if(!empty($images)){
            $ext = $images->getClientOriginalExtension();
            $newName = time().'.'.$ext;
            $temImage = TemImages::create([
                'name' => $newName,
            ]);

            $images->move(public_path().'/tem', $newName);

            return response()->json([
                'status' => true,
                'image_id' => $temImage->id,
                'message' => 'File has successfully Loaded'
            ]);
        }
       
        

        
    }
}
