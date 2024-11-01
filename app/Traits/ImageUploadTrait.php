<?php
namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Image;

trait ImageUploadTrait 
{
    public function handleUploadImage($request, $fieldName, $foderName): ?string 
    {
        if ($request->hasFile($fieldName)) {  
            $image = $request->file($fieldName);  
            $imageName = Str::random(10) . "_" . $image->getClientOriginalName(); 
            $path = $request->file($fieldName)->storeAs('public/' . $foderName, $imageName); 
            $dataPath = Storage::url($path);
            return $dataPath; 
        }
        return null;
    }

    public function handleUploadImageProduct($request, $fieldName, $foderName): array 
    {
        $dataPath = [];
        if ($request->hasFile($fieldName)) {
            foreach ($request->$fieldName as $item) {
                $imageName = Str::random(10) . "_" . $item->getClientOriginalName();
                $path = $item->storeAs('public/' . $foderName, $imageName);

                $dataPath[$imageName] = Storage::url($path);
            }
        }
        return $dataPath;
    }

    public function handleUploadImageLogo($request, $fieldName, $folderName): ?string 
    {  
        if ($request->hasFile($fieldName)) {
            $image = $request->file($fieldName);
            $imageName = Str::random(10) . "_" . $image->getClientOriginalName();
            $path = $request->file($fieldName)->storeAs('public/' . $folderName, $imageName);
    
            $imagePath = storage_path("app/{$path}");
    
            list($width, $height, $type) = getimagesize($imagePath);
            
            $newWidth = 80;
            $newHeight = 80;
    
            $newImage = imagecreatetruecolor($newWidth, $newHeight); 
            
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $sourceImage = imagecreatefromjpeg($imagePath);
                    break;
                case IMAGETYPE_PNG:
                    $sourceImage = imagecreatefrompng($imagePath);
                    break;
                case IMAGETYPE_GIF:
                    $sourceImage = imagecreatefromgif($imagePath);
                    break;
                default:
                    return null;
            }
    
            imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
            switch ($type) {
                case IMAGETYPE_JPEG:
                    imagejpeg($newImage, $imagePath);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($newImage, $imagePath);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($newImage, $imagePath);
                    break;
            }
    
            imagedestroy($newImage);
            imagedestroy($sourceImage);
    
            return Storage::url($path);
        }
    
        return null;
    }
    

}