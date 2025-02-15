<?php

namespace App\Traits;

use App\Http\Requests\FileUploadRequest;
use App\Models\FileUpload as UploadFile;

trait FileUpload
{

    public function upload(FileUploadRequest $request, $path, $generate_id)
    {
        try {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $image = $request->file('file');
                $file = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = date('Y') . '-' . $file . '-' . $generate_id . '.' . $image->extension();

                // Ensure directory exists inside 'public/img/...'
                $dir =  trim($path, '/'); // Store relative to public/
                $image->move(public_path($dir), $filename);

                // Generate public URL
                $file_url = asset($dir . '/' . $filename);

                // Store in the database
                UploadFile::create([
                    'target_id' => $generate_id,
                    'filename' => $filename,
                    'file_location' => asset($dir . '/'), // Store URL instead of absolute path
                ]);

                return response()->json([
                    'filename' => $filename,
                    'file_location' => asset($dir . '/'),
                    'full_path_location' => $file_url, // Ensure public URL is returned
                ], 201);
                
            }
        } catch (\Exception $e) {
            // Catch any exception and return an error response with the exception message.
            return response()->json([
                'error' => 'An error occurred while uploading file',
                'message' => $e->getMessage() // Message from the caught exception.
            ]);
        }
    }
}
