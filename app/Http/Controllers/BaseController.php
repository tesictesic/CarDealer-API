<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nette\Utils\Image;

class BaseController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.home');
    }
    function cutImage(Request $request,$profile = false) {
        $file = $request->file('picture');
        $tmpPath =$file->getPathname();
        $name = $file->getClientOriginalName();
        $type = $file->getMimeType();
        list($width, $height) = getimagesize($tmpPath);

        $newWidth = $profile ? 250 : 180;
        $newHeight = $profile ? 250 : 180;
        $putanja=$profile?"assets/images/users/":"assets/images/cars/";
        $putanja_resize=$profile?"assets/images/users-resize/":"assets/images/cars-resize/";

        if ($type == "image/jpeg") {
            $originalImage = imagecreatefromjpeg($tmpPath);
        } elseif ($type == "image/png") {
            $originalImage = imagecreatefrompng($tmpPath);
        }
        $imagePath = public_path($putanja) . $name;
        $resizeImagePath = public_path($putanja_resize) . $name;

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        move_uploaded_file($tmpPath, $imagePath);
        if($type=='image/jpeg') imagejpeg($resizedImage,  $resizeImagePath );
        if($type=='image/png') imagepng($resizedImage,  $resizeImagePath);


        // Optionally, save the original image

    }
}
