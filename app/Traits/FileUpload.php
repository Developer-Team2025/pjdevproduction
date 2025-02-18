<?php

namespace App\Traits;

use App\Http\Requests\FileUploadRequest;
use App\Models\FileUpload as UploadFile;
use Illuminate\Http\JsonResponse;

trait FileUpload
{
    /**
     * Handle file upload and store metadata in the database.
     *
     * This method validates and uploads the file, generates a unique filename,
     * stores the file in the specified directory, and saves the file information
     * in the database.
     *
     * @param  \App\Http\Requests\FileUploadRequest  $request  The request containing the file.
     * @param  string  $path  The directory path where the file should be stored.
     * @param  string  $generate_id  A unique identifier associated with the file.
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(FileUploadRequest $request, $path, $generate_id): JsonResponse
    {
        try {
            // Check if the request contains a valid file
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $image = $request->file('file');

                // Extract the original filename without extension
                $file = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                // Generate a new filename with timestamp and unique ID
                $filename = date('Y') . '-' . $file . '-' . $generate_id . '.' . $image->extension();

                // Ensure the directory structure exists inside 'public/img/...'
                $dir =  trim($path, '/');

                // Move the file to the designated directory inside the public folder
                $image->move(public_path($dir), $filename);

                // Determine the storage URL based on the environment (localhost or production)
                $storage = $_SERVER['HTTP_HOST'] === "localhost:" . $_SERVER['SERVER_PORT'] ? asset($dir . '/' . $filename) : asset('google-sheets-api/public/' . $dir . '/' . $filename);

                // Normalize the storage location path
                $target_storage_location = str_replace('\\', '/', dirname($storage) . DIRECTORY_SEPARATOR);

                // Store file metadata in the database
                UploadFile::create([
                    'target_id' => $generate_id,
                    'filename' => $filename,
                    'file_location' => $target_storage_location, // Store URL instead of absolute path
                ]);

                // Return a success response with file details
                return response()->json([
                    'filename' => $filename,
                    'file_location' => $target_storage_location,
                    'full_path_location' => str_replace('\\', '/', $storage),
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
