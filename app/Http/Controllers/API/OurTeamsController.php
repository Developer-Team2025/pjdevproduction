<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOurTeamRequest;
use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\OurTeamCollection;
use App\Models\OurTeam;
use App\Traits\FileUpload;
use App\Traits\GenerateUniqueId;
use Illuminate\Http\Request;

class OurTeamsController extends Controller
{
    use GenerateUniqueId, FileUpload;

    /**
     * Retrieve all team members with their associated profile images.
     *
     * This method fetches all records from the OurTeam model along with
     * their related team profile images from the FileUpload model.
     *
     * @return \App\Http\Resources\OurTeamCollection
     */
    public function getOurTeams(Request $request)
    {
        
        $get_data = new OurTeamCollection(OurTeam::with('teamProfileImages')->get());

        return response()->json($get_data);
    }

    /**
     * Create a new team member profile with an uploaded profile image.
     *
     * This method generates a unique team ID, handles file upload, 
     * and creates a new record in the OurTeam model.
     *
     * @param  \App\Http\Requests\CreateOurTeamRequest  $request
     * @param  \App\Http\Requests\FileUploadRequest  $file_request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOurTeamProfile(CreateOurTeamRequest $request, FileUploadRequest $file_request)
    {
        try {
            // Generate a unique ID for the team member
            $generate_id = $this->generateID();

            // Upload the profile image and associate it with the generated ID
            $file_upload = $this->upload($file_request, 'img/our-teams/', $generate_id);

            // Create a new team member record in the database
            OurTeam::create([
                'team_id' => $generate_id,
                'fullname' => $request->fullname,
                'job_position' => $request->job_position,
            ]);

            // Return a success response with the new team member's details
            return response()->json([
                'fullname' => $request->fullname,
                'job_position' => $request->job_position,
                'profile_img' => $file_upload->getData(),
            ]);
            
        } catch (\Exception $e) {
            // Catch any exception and return an error response with the exception message.
            return response()->json([
                'error' => 'An error occurred while saving data',
                'message' => $e->getMessage() // Message from the caught exception.
            ]);
        }
    }
}
