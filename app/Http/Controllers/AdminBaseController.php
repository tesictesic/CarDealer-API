<?php

namespace App\Http\Controllers;

use App\Models\AdminBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminBaseController extends Controller
{
    public function index()
    {

    }
    function cutImage(Request $request,$profile = false) {
        $file=$profile?$request->file('picture'):$request->file('image');
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
