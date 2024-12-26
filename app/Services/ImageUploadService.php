<?php 

namespace App\Services;

use App\Models\All\TmpImage;

class ImageUploadService 
{

   /**
     * handle image upload using any third party plugin like filepond
     *
     */
    public function handleImageUpload($model, $images, $collection, $conversion_name, $action)
    {
        $image_filename = [];
        $uploaded_images = [];

            $action == "update" ?  $model->clearMediaCollection($collection) : "";

            if(is_array($images))
            {
                // loop array of images
                foreach($images as $img)
                {
                    $image_filename[]= $img;
                    $uploaded_images[] = $model->addMedia(storage_path('/app/public/tmp/'. $img))->toMediaCollection($collection)->getUrl($conversion_name); // move the image from the storage disk to the new media disk

                }  

                TmpImage::whereIn('filename', $image_filename)->delete(); // get the tmp image from the db & remove it
                return $uploaded_images;
            }

            return $model->addMedia(storage_path('/app/public/tmp/'. $images))->toMediaCollection($collection)->getUrl($conversion_name);
    }

    /**
     * handle image upload without using any third party plugin like filepond
     *
     */
    public function handleSimpleImageUpload($file, $folder)
    {
        $file_name = $file->hashName(); // generate unique file name 

       return $file->storeAs($folder, $file_name, 'public') ? $file_name : false;

    }
}