<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoogleSheetsApiRequest;
use App\Services\GoogleServices;
use Illuminate\Http\JsonResponse;

/**
 * Class GoogleSheetApiController
 * Handles operations related to writing data into Google Sheets.
 * 
 * @package App\Http\Controllers
 */
class GoogleSheetsApiController extends Controller
{
    /**
     * @var GoogleApiServices
     * Service to interact with Google Sheets API.
     */
    private $api_services;

    /**
     * GoogleSheetApiController constructor.
     *
     * @param GoogleApiServices $services to handle Google Sheets API operations.
     */
    public function __construct(GoogleServices $api_services)
    {
        $this->api_services = $api_services;
    }

    /**
     * Writes form data to a Google Sheet.
     *
     * This method validates the input data and writes it to the specified Google Sheet.
     * It also checks if the header row exists before adding it.
     *
     * @param GoogleSheetApiRequest $form_request The validated form request containing data.
     * 
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function writeSheet(GoogleSheetsApiRequest $request): JsonResponse
    {
        try {
            // Google Sheets settings
            $ssid = '1660409-8EKI1oxfJXP55EFfgNnmrwAU3H_sLyEyNuik';
            $sheet_tab = 'Sheet1';

            // Define header columns
            $column_header = ['Full Name', 'Email', 'Phone', 'Inquiry Type', 'Country', 'Accept Privacy'];

            empty($this->api_services->sheets($ssid, $sheet_tab)) ? $this->api_services->rows($ssid, $sheet_tab, [$column_header]) : false;

            // Prepare the data to be written
            $input = [
                $request->input('fullname'),
                $request->input('email'),
                $request->input('phone'),
                $request->input('inquiry_type'),
                $request->input('country'),
                $request->boolean('accept_privacy') ? 1 : 0,
            ];

            $this->api_services->rows($ssid, $sheet_tab, [$input]);

            // Return success response
            return response()->json(['response' => 'Successfully Saved'], 201);

        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'error' => 'An error occurred while saving data',
                'message' => $e->getMessage()
            ]);
        }
    }
}
