<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoogleSheetsApiRequest;
use App\Services\GoogleServices;
use Illuminate\Http\JsonResponse;
use App\Models\GoogleSheetSubmission;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ClearValuesRequest;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateValuesRequest;

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
        $ssid = env('SheetId');
        $sheet_tab = env('Sheets');

        $client = self::getClientInstance();
        $service = new Google_Service_Sheets($client);
        $response = $service->spreadsheets_values->get( $ssid, $sheet_tab);
        $values = $response->getValues();

        try {
            // Google Sheets settings
            $ssid = env('SheetId');
            $sheet_tab = env('Sheets'); // Sheet2!A1 | Sheet2

            // Define header columns
            $column_header = ['Full Name', 'Email', 'Phone', 'Inquiry Type', 'Country', 'Accept Privacy', 'Date'];

            empty($this->api_services->sheets($ssid, $sheet_tab)) ? $this->api_services->rows($ssid, $sheet_tab, [$column_header]) : false;

            // Prepare the data to be written
            $input = [
                $request->input('fullname'),
                $request->input('email'),
                $request->input('phone'),
                $request->input('inquiry_type'),
                $request->input('country') === 'Africa'  ? $request->input('country') : 'Africa'  ,
                $request->boolean('accept_privacy') ? "Accepted" : false,
                $request->input('date_now') === Null ? date('D M d, Y, h:i:s') : $request->input('date_now')
            ];

            //Google Sheet add API
            $date_text = date('D M d'); // Example: "Thu Mar 23"
            $date_format = date('j/n/Y');
            $existingData = app(\App\Services\GoogleServices::class)->sheets($ssid, $sheet_tab, );
            $key = false;

            foreach ($existingData as $index => $row) {
                if (isset($row[0]) && $row[0] === $date_format) {
                    $key = $index;
                    break;
                }
            }
            
            if ($key === false) {
                $this->api_services->addMergedRow($ssid, $sheet_tab, [[$date_format]]);
            }
            
            $this->api_services->rows($ssid, $sheet_tab, [$input]);

            $this->api_services->addRow($ssid, 6, $sheet_tab);

            
            GoogleSheetSubmission::create([
                'fullname'      => $request->input('fullname'),
                'email'          => $request->input('email'),
                'phone'          => $request->input('phone'),
                'inquiry_type'   => $request->input('inquiry_type'),
                'country'        => $request->input('country') === 'Africa' ? 'Africa' : $request->input('country'),
                'accept_privacy' => $request->boolean('accept_privacy') ? 1 : 0, // ✅ Integer value
                'date_now'       => $request->input('date_now') === Null ? date('D M d, Y, h:i:s') : $request->input('date_now')
            ]);

            // Return success response
            $this->syncSheetToDatabase();
            return response()->json(['response' => 'Successfully Saved'], 201);

        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'error' => 'An error occurred while saving data',
                'message' => $e->getMessage()
            ]);
        }
    }

    private static function getClientInstance(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName('Laravel Google Sheets API');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig(storage_path('app/hackz-decoder-02ad9844a236.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        return $client;
    }

    // private function syncSheetToDatabase(): void
    // {
    //     try {
    //         $ssid = env('SheetId');
    //         $sheet_tab = env('Sheets');
    
    //         $client = self::getClientInstance();
    //         $service = new \Google_Service_Sheets($client);
    //         $response = $service->spreadsheets_values->get($ssid, $sheet_tab);
    //         $rows = $response->getValues();
    
    //         \Log::info('Sheet rows:', $rows);
    
    //         if (count($rows) <= 1) {
    //             \Log::warning('No data to sync (only header row)');
    //             return;
    //         }
    
    //         $headers = array_map('strtolower', $rows[0]);
    
    //         foreach (array_slice($rows, 1) as $row) {
    //             $data = array_combine($headers, $row + array_fill(0, count($headers), null));
                
    //             if (!isset($data['email'])) continue;
    
    //             $exists = \App\Models\GoogleSheetSubmission::where('email', $data['email'])->exists();
    
    //             if ($exists) {
    //                 \Log::info('Skipping existing email: ' . $data['email']);
    //                 continue;
    //             }
    
    //             \App\Models\GoogleSheetSubmission::create([
    //                 'fullname'        => $data['full name'] ?? '',
    //                 'email'           => $data['email'] ?? '',
    //                 'phone'           => $data['phone'] ?? '',
    //                 'inquiry_type'    => $data['inquiry type'] ?? '',
    //                 'country'         => $data['country'] ?? '',
    //                 'accept_privacy'  => strtolower($data['accept privacy'] ?? '') === 'accepted' ? 1 : 0,
    //                 'date_now'        => $data['date'] ?? now(),
    //             ]);
    
    //             \Log::info('Inserted: ' . $data['email']);
    //         }
    
    //     } catch (\Exception $e) {
    //         \Log::error('Sync failed: ' . $e->getMessage());
    //     }
    // }
    private function syncSheetToDatabase(): void
    {
        try {

            
            $ssid = env('SheetId');
            $sheet_tab = env('Sheets');
    
            $client = self::getClientInstance();
            $service = new \Google_Service_Sheets($client);
            $response = $service->spreadsheets_values->get($ssid, $sheet_tab);
            $rows = $response->getValues();
    
            \Log::info('Sheet rows:', $rows);
    
            if (count($rows) <= 1) {
                \Log::warning('No data to sync (only header row)');
                return;
            }
    
            $headers = array_map('strtolower', $rows[0]);
    
            foreach (array_slice($rows, 1) as $row) {
                // Pad row to match headers length
                $row = array_pad($row, count($headers), null);
                $data = array_combine($headers, $row);
    
                if (!isset($data['email']) || empty($data['email'])) {
                    \Log::info('Skipping row with empty email.');
                    continue;
                }
    
                $exists = \App\Models\GoogleSheetSubmission::where('email', $data['email'])->exists();
    
                if ($exists) {
                    \Log::info('Skipping existing email: ' . $data['email']);
                    continue;
                }
    
                try {
                    \App\Models\GoogleSheetSubmission::create([
                        'fullname'        => $data['full name'] ?? '',
                        'email'           => $data['email'] ?? '',
                        'phone'           => $data['phone'] ?? '',
                        'inquiry_type'    => $data['inquiry type'] ?? '',
                        'country'         => $data['country'] ?? '',
                        'accept_privacy'  => strtolower($data['accept privacy'] ?? '') === 'accepted' ? 1 : 0,
                        'date_now'        => $data['date'] ?? now(),
                    ]);
    
                    \Log::info('Inserted: ' . $data['email']);
                } catch (\Illuminate\Database\QueryException $ex) {
                    \Log::warning('Duplicate email or DB error: ' . $data['email'] . ' | ' . $ex->getMessage());
                }
            }
    
        } catch (\Exception $e) {
            \Log::error('Sync failed: ' . $e->getMessage());
        }
    }
     

}
