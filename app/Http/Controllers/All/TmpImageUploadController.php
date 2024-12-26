<?php

namespace App\Http\Controllers\All;

use App\Models\All\TmpImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Support\Facades\Storage;

class TmpImageUploadController extends Controller
{
    public function store(Request $request)
    {
        if($request->hasFile('image') || $request->hasFile('avatar') || $request->hasFile('featured_photos') || $request->hasFile('proof_of_ownership') || $request->hasFile('vaccination_history_image') || $request->hasFile('deworming_history_image')) 
        {
            // if its an array of images
            if(is_array($request->image)) 
            {
                $images = $request->image;

                foreach($images as $img): 
                    
                    $img_file_name = $img->hashName(); // get the unique hashname
    
                    $img->storeAs('tmp', $img_file_name , 'public');  // store on the default disk ( storage > app > public)
    
                    TmpImage::create(['filename' => $img_file_name]); // store temporarily on the server
    
                    return $img_file_name; // every requested images ; return 
    
                endforeach;
      
            }

            else if(is_array($request->featured_photos))
            {
                    $featured_photos = $request->featured_photos;

                    foreach($featured_photos as $featured_photo): 
                        
                        $featured_photo_file_name = $featured_photo->hashName(); // get the unique hashname
        
                        $featured_photo->storeAs('tmp', $featured_photo_file_name , 'public');  // store on the default disk ( storage > app > public)
        
                        TmpImage::create(['filename' => $featured_photo_file_name]); // store temporarily on the server
        
                        return $featured_photo_file_name; // every requested featured_photos ; return 
        
                    endforeach;
            }

            else if(is_array($request->vaccination_history_image))
            {
                    $vaccination_history_images = $request->vaccination_history_image;

                    foreach($vaccination_history_images as $vaccination_history_image): 
                        
                        $vaccination_history_image_file_name = $vaccination_history_image->hashName(); // get the unique hashname
        
                        $vaccination_history_image->storeAs('tmp', $vaccination_history_image_file_name , 'public');  // store on the default disk ( storage > app > public)
        
                        TmpImage::create(['filename' => $vaccination_history_image_file_name]); // store temporarily on the server
        
                        return $vaccination_history_image_file_name; // every requested vaccination_history_images ; return 
        
                    endforeach;
            }

            else if(is_array($request->deworming_history_image))
            {
                    $deworming_history_images = $request->deworming_history_image;

                    foreach($deworming_history_images as $deworming_history_image): 
                        
                        $deworming_history_image_file_name = $deworming_history_image->hashName(); // get the unique hashname
        
                        $deworming_history_image->storeAs('tmp', $deworming_history_image_file_name , 'public');  // store on the default disk ( storage > app > public)
        
                        TmpImage::create(['filename' => $deworming_history_image_file_name]); // store temporarily on the server
        
                        return $deworming_history_image_file_name; // every requested deworming_history_images ; return 
        
                    endforeach;
            }
            
            else
            {
                $image = $request->image ?? $request->avatar ?? $request->proof_of_ownership;

                $image_name = $image->hashName(); // hashed name of an image ( Unique)
    
                $image->storeAs('tmp', $image_name, 'public'); // store to the default storage driver temporarily
    
                TmpImage::create(['filename' => $image_name]);
    
                return $image_name;
            }

        }

        return 'not found';
    }

    public function revert(Request $request)
    {
        $image = $request->getContent();

        Storage::disk('public')->delete("tmp/$image"); // remove from the tmp folder
        TmpImage::where('filename', $image)->delete(); // remove from the tmp db tbl

        return;
    }

   
}