<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CertificateController extends Controller
{
    public function getCertificates()
    {
        $imageFiles = File::files(public_path('dist/img/certificate/'));
        $url = url('/');

        // Filter out the images (e.g., jpg, png) and store in an array
        $images = [];
        foreach ($imageFiles as $file) {
            if (array($file->getExtension())) {
                $imageName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $arr = array('src' => "$url/dist/img/certificate/" . $file->getFilename(), 'alt' => $imageName);
                $images[] =  $arr; // Add file name to the array
            }

            return response()->json($images);
        }
    }
}
