<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

/**
 * Class GoogleSheetsApiServices
 * 
 * Handles interactions with the Google Sheets API.
 *
 * @package App\Services
 */
class GoogleServices
{
    /**
     * @var Sheets Google Sheets service instance.
     */
    private $services;

    /**
     * GoogleSheetsApiServices constructor.
     * 
     * Initializes the Google Client and sets up authentication for accessing Google Sheets.
     */
    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/hackz-decoder-02ad9844a236.json'));
        $client->addScope(Sheets::SPREADSHEETS);

        $this->services = new Sheets($client);
    }

    // private function mergeRow(string $spreadsheet_id, int $sheetId, int $rowIndex, int $startColumn, int $endColumn)
    // {
    //     try {
    //         $mergeRequest = new \Google\Service\Sheets\Request([
    //             'mergeCells' => [
    //                 'range' => [
    //                     'sheetId' => $sheetId,
    //                     'startRowIndex' => $rowIndex,
    //                     'endRowIndex' => $rowIndex + 1, // One row only
    //                     'startColumnIndex' => $startColumn,
    //                     'endColumnIndex' => $endColumn + 1, // Merge A-G (0-6)
    //                 ],
    //                 'mergeType' => 'MERGE_ALL'
    //             ]
    //         ]);

    //         $batchRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
    //             'requests' => [$mergeRequest]
    //         ]);

    //         $this->services->spreadsheets->batchUpdate($spreadsheet_id, $batchRequest);
    //         \Log::info("Row {$rowIndex} merged from column {$startColumn} to {$endColumn}.");

    //     } catch (\Exception $e) {
    //         \Log::error("Google Sheets API Merge Error: " . $e->getMessage());
    //     }
    // }

    /**
     * Retrieves data from a specified Google Sheet range.
     *
     * @param string $spreadsheet_id The ID of the Google Sheet.
     * @param string $range The range of cells to fetch data from.
     * 
     * @return array|null Returns an array of values or null if no data is found.
     */
    public function sheets(string $spreadsheet_id, string $range)
    {
        return $this->services->spreadsheets_values->get($spreadsheet_id, $range)->getValues();
    }

    /**
     * Appends data to a specified Google Sheet.
     *
     * @param string $spreadsheet_id The ID of the Google Sheet.
     * @param string $range The range where data should be inserted.
     * @param array $data The data to be appended.
     * 
     * @return \Google\Service\Sheets\AppendValuesResponse The response from the API.
     */

    // public function addTable(string $ssid, string $sheet_tab){
    //     // $ssid = env('SheetId');
    //     // $sheet_tab = env('Sheets'); // Ensuring data is checked in Sheet2

    //     // Retrieve existing sheet data
    //     $existingData = app(\App\Services\GoogleServices::class)->sheets($ssid, $sheet_tab);
    //     $date_time = [[date("D M d")]];
    //     $body = new Sheets\ValueRange(['values' => $date_time]);
    //     $parameters = [
    //         'valueInputOption' => 'RAW',
    //         'insertDataOption' => 'INSERT_ROWS',
    //     ];
    //     $rowIndex = count($existingData) + 1; // New row index
    //     $mergeCellsRequest = new \Google\Service\Sheets\Request([
    //         'mergeCells' => [
    //             'range' => [
    //                 'sheetId' => $sheet_tab,
    //                 'startRowIndex' => $rowIndex - 1,
    //                 'endRowIndex' => $rowIndex ,
    //                 'startColumnIndex' => 0,
    //                 'endColumnIndex' => 7
    //             ],
    //             'mergeType' => 'MERGE_ALL'
    //         ]
    //     ]);
    //     // $mergeRequest = new \Google\Service\Sheets\Request([
    //     //         [
    //     //             'mergeCells' => [
    //     //                 'range' => [
    //     //                     'sheetId' => $this->getSheetId($ssid, $sheet_tab), // Get sheet ID
    //     //                     'startRowIndex' => $rowIndex - 1, // Google Sheets index is 0-based
    //     //                     'endRowIndex' => $rowIndex,
    //     //                     'startColumnIndex' => 0,  // Column A (0-based index)
    //     //                     'endColumnIndex' => 7,    // Column G (Exclusive, so G is index 6 + 1)
    //     //                 ],
    //     //                 'mergeType' => 'MERGE_ALL'
    //     //             ]
    //     //         ]
    //     //     ]);
    //     $appendResult = $this->services->spreadsheets_values->append($ssid, $sheet_tab, $body, $parameters);
    //     $requestBody = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
    //         // 'requests' => [$sortRequest, $headerFormatRequest, $dataFormatRequest, $autoResizeRequest, $mergeCellsRequest, $insertDateRequest]
    //         'requests' => [ $mergeCellsRequest]
    //     ]);
    //     if($existingData !== Null){
    //         $key = false;
    //         foreach ($existingData as $index => $row) {
    //             if ($row[0] === $date_time[0][0]) { // Fix comparison
    //                 $key = $index;
    //                 break;
    //             }
    //         }
    //         if ($key === false) {
    //             $this->services->spreadsheets->batchUpdate($ssid, $requestBody);
    //             return $appendResult;
    //         }
    //     }else{
    //         $this->services->spreadsheets->batchUpdate($ssid, $requestBody);
    //         return $appendResult;
    //     }
    // }


// public function addTable(string $ssid, string $sheet_tab) {
//     // Retrieve existing sheet data
//     $existingData = app(\App\Services\GoogleServices::class)->sheets($ssid, $sheet_tab);
//     $date_time = [[date("D M d")]];
//     $body = new Sheets\ValueRange(['values' => $date_time]);
//     $parameters = [
//         'valueInputOption' => 'RAW',
//         'insertDataOption' => 'INSERT_ROWS',
//     ];

//     // Get the numeric sheet ID
//     $sheetId = $this->getSheetId($ssid, $sheet_tab);
//     if (!is_int($sheetId)) {
//         throw new \Exception("Invalid sheet ID: Must be an integer.");
//     }

//     // Calculate the new row index
//     $rowIndex = ($existingData !== null) ? count($existingData) + 1 : 1;

//     // Merge request: Merge cells from A to G in the new row
//     $mergeRequest = [
//         'requests' => [
//             [
//                 'mergeCells' => [
//                     'range' => [
//                         'sheetId' => $sheetId,  // Fixed: Now using a valid integer sheet ID
//                         'startRowIndex' => $rowIndex - 1, // Google Sheets is 0-based
//                         'endRowIndex' => $rowIndex,
//                         'startColumnIndex' => 0,  // Column A (0-based index)
//                         'endColumnIndex' => 7,    // Column G (Exclusive)
//                     ],
//                     'mergeType' => 'MERGE_ALL'
//                 ]
//             ]
//         ]
//     ];


//         // Check if data already exists to avoid duplicate merges
//         if ($existingData != Null) {
//             $key = false;
//             foreach ($existingData as $index => $row) {
//                 if ($row[0] === $date_time[0][0]) {
//                     $key = $index;
//                     break;
//                 }
//             }
//             if ($key === false) {
//                 // Apply the merge request
//                 $this->services->spreadsheets->batchUpdate(
//                     $ssid,
//                     new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest($mergeRequest)
//                 );
//                 return $$this->services->spreadsheets_values->append($ssid, $sheet_tab, $body, $parameters);
//             }
//         } else {
//             // If no existing data, merge the new row
//             $this->services->spreadsheets->batchUpdate(
//                 $ssid,
//                 new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest($mergeRequest)
//             );
//             return $$this->services->spreadsheets_values->append($ssid, $sheet_tab, $body, $parameters);
//         }
    

// }

// // Helper function to get the numeric sheet ID
// private function getSheetId(string $ssid, string $sheet_tab): int {
//     $spreadsheet = $this->services->spreadsheets->get($ssid);
//     foreach ($spreadsheet->getSheets() as $sheet) {
//         if ($sheet->getProperties()->getTitle() === $sheet_tab) {
//             return $sheet->getProperties()->getSheetId();
//         }
//     }
//     throw new \Exception("Sheet '$sheet_tab' not found.");
// }



public function addTable(string $ssid, string $sheet_tab, array $dateEntry)
{
    $existingData = app(\App\Services\GoogleServices::class)->sheets($ssid, $sheet_tab);
    $sheetId = $this->getSheetId($ssid, $sheet_tab);
    $date_text = $dateEntry[0][0];

    $body = new Sheets\ValueRange(['values' => $dateEntry]);
    $parameters = [
        'valueInputOption' => 'RAW',
        'insertDataOption' => 'INSERT_ROWS',
    ];

    // Get last row index before inserting the new date
    $lastRow = ($existingData !== null) ? count($existingData) : 0;

    // Append date
    $appendResponse = $this->services->spreadsheets_values->append($ssid, $sheet_tab, $body, $parameters);

    // Apply bold formatting **only** to the inserted date row
    $mergeRequest = [
        'mergeCells' => [
            'range' => [
                'sheetId' => $sheetId,
                'startRowIndex' => $lastRow,  // Newly inserted date row
                'endRowIndex' => $lastRow + 1,
                'startColumnIndex' => 0,
                'endColumnIndex' => 7,
            ],
            'mergeType' => 'MERGE_ALL'
        ]
    ];

    $formatRequest = [
        'repeatCell' => [
            'range' => [
                'sheetId' => $sheetId,
                'startRowIndex' => $lastRow,
                'endRowIndex' => $lastRow + 1,
                'startColumnIndex' => 0,
                'endColumnIndex' => 7,
            ],
            'cell' => [
                'userEnteredFormat' => [
                    'horizontalAlignment' => 'CENTER',
                    'verticalAlignment' => 'MIDDLE',
                    'textFormat' => [
                        'bold' => true,
                        'fontSize' => 14
                    ]
                ]
            ],
            'fields' => 'userEnteredFormat(horizontalAlignment,verticalAlignment,textFormat.bold,textFormat.fontSize)'
        ]
    ];

    // Apply merging & formatting
    $this->services->spreadsheets->batchUpdate(
        $ssid,
        new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => [$mergeRequest, $formatRequest]
        ])
    );

    return $appendResponse;
}




// Helper function to get sheet ID
private function getSheetId(string $ssid, string $sheet_tab): int {
    $spreadsheet = $this->services->spreadsheets->get($ssid);
    foreach ($spreadsheet->getSheets() as $sheet) {
        if ($sheet->getProperties()->getTitle() === $sheet_tab) {
            return $sheet->getProperties()->getSheetId();
        }
    }
    throw new \Exception("Sheet '$sheet_tab' not found.");
}



public function rows(string $spreadsheet_id, string $range, array $data)
{
    $body = new Sheets\ValueRange(['values' => $data]);

    $parameters = [
        'valueInputOption' => 'RAW',
        'insertDataOption' => 'INSERT_ROWS',
    ];

    // Append new values
    $appendResponse = $this->services->spreadsheets_values->append($spreadsheet_id, $range, $body, $parameters);

    // Get sheet ID dynamically
    $sheetId = $this->getSheetId($spreadsheet_id, $range);

    // Get total rows (to locate the newly inserted ones)
    $existingData = app(\App\Services\GoogleServices::class)->sheets($spreadsheet_id, $range);
    $startRow = count($existingData) - count($data); // First row of new entries
    $endRow = count($existingData); // Last row of new entries

    // Reset formatting for the newly added rows (remove bold)
    $resetFormatRequest = [
        'repeatCell' => [
            'range' => [
                'sheetId' => $sheetId,
                'startRowIndex' => $startRow,
                'endRowIndex' => $endRow,
                'startColumnIndex' => 0,
                'endColumnIndex' => 7,
            ],
            'cell' => [
                'userEnteredFormat' => [
                    'textFormat' => [
                        'bold' => false,
                        'fontSize' => 12
                    ],
                    'horizontalAlignment' => 'LEFT'
                ]
            ],
            'fields' => 'userEnteredFormat(textFormat.bold,textFormat.fontSize,horizontalAlignment)'
        ]
    ];

    // Apply formatting reset
    $this->services->spreadsheets->batchUpdate(
        $spreadsheet_id,
        new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => [$resetFormatRequest]
        ])
    );

    return $appendResponse;
}


    /**
     * Sorts the Google Sheet in descending order based on a given column.
     *
     * @param string $spreadsheet_id The ID of the Google Sheet.
     * @param int $columnIndex The index of the column to sort by (0-based).
     * @return void
     */

    public function addRow(string $spreadsheet_id, int $columnIndex, string $sheetTitle)
    {
        try {
            $spreadsheet = $this->services->spreadsheets->get($spreadsheet_id);
            $sheetId = null;

            foreach ($spreadsheet->getSheets() as $sheet) {
                if ($sheet->getProperties()->getTitle() === $sheetTitle) {
                    $sheetId = $sheet->getProperties()->getSheetId();
                    break;
                }
            }

            if ($sheetId === null) {
                \Log::error("Google Sheets API: Sheet '{$sheetTitle}' not found.");
                return;
            }

            // Sorting request (skip header row)
            $sortRequest = new \Google\Service\Sheets\Request([
                'sortRange' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 1, // Skip header row
                        'startColumnIndex' => 0,
                        'endColumnIndex' => 7,
                    ],
                    'sortSpecs' => [
                        [
                            'dimensionIndex' => $columnIndex,
                            'sortOrder' => 'ASCENDING'
                        ]
                    ]
                ]
            ]);

            // Header Formatting (KEEP this as is, Blue Background)
            $headerFormatRequest = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 0, // Header row only
                        'endRowIndex' => 1,
                        'startColumnIndex' => 0,
                        'endColumnIndex' => 7,
                    ],
                    'cell' => [
                        'userEnteredFormat' => [
                            'textFormat' => [
                                'bold' => true,
                                'foregroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1] // White text
                            ],
                            'horizontalAlignment' => 'LEFT',
                            'backgroundColor' => ['red' => 0.26, 'green' => 0.53, 'blue' => 0.96] // Blue background (#4287f5)
                        ]
                    ],
                    'fields' => 'userEnteredFormat(textFormat, horizontalAlignment, backgroundColor)'
                ]
            ]);

            // Data Formatting (Reset to Default: REMOVE Background Color)
            $dataFormatRequest = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => 1, // Data rows start from row 2
                        'startColumnIndex' => 0,
                        'endColumnIndex' => 7,
                    ],
                    'cell' => [
                        'userEnteredFormat' => [
                            'textFormat' => ['bold' => false], // Regular text
                            'horizontalAlignment' => 'LEFT' // Left-aligned text
                        ]
                    ],
                    'fields' => 'userEnteredFormat(textFormat, horizontalAlignment)'
                ]
            ]);

            // Auto-Resize Columns
            $autoResizeRequest = new \Google\Service\Sheets\Request([
                'autoResizeDimensions' => [
                    'dimensions' => [
                        'sheetId' => $sheetId,
                        'dimension' => 'COLUMNS',
                        'startIndex' => 0,
                        'endIndex' => 7
                    ]
                ]
            ]);

            // Get last row index dynamically
            $sheetData = $this->services->spreadsheets_values->get($spreadsheet_id, $sheetTitle);

            $lastRowIndex = count($sheetData->getValues());

            // Merge row below existing data
            $mergeCellsRequest = new \Google\Service\Sheets\Request([
                'mergeCells' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => $lastRowIndex,
                        'endRowIndex' => $lastRowIndex + 1,
                        'startColumnIndex' => 0,
                        'endColumnIndex' => 7
                    ],
                    'mergeType' => 'MERGE_ALL'
                ]
            ]);

            

            // Insert current date into the merged row and center align
            $currentDate = date('Y-m-d');

            $insertDateRequest = new \Google\Service\Sheets\Request([
                'repeatCell' => [
                    'range' => [
                        'sheetId' => $sheetId,
                        'startRowIndex' => $lastRowIndex,
                        'endRowIndex' => $lastRowIndex + 1,
                        'startColumnIndex' => 0,
                        'endColumnIndex' => 1
                    ],
                    'cell' => [
                        'userEnteredValue' => ['stringValue' => $currentDate],
                        'userEnteredFormat' => [
                            'horizontalAlignment' => 'CENTER'
                        ]
                    ],
                    'fields' => 'userEnteredValue, userEnteredFormat(horizontalAlignment)'
                ]
            ]);

            // Execute batch update
            $requestBody = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                // 'requests' => [$sortRequest, $headerFormatRequest, $dataFormatRequest, $autoResizeRequest, $mergeCellsRequest, $insertDateRequest]
                'requests' => [ $headerFormatRequest]
            ]);

            $this->services->spreadsheets->batchUpdate($spreadsheet_id, $requestBody);

            \Log::info("Sorting, header formatting, and merged date row applied successfully for '{$sheetTitle}'.");

        } catch (\Exception $e) {
            \Log::error('Google Sheets API Sort Error: ' . $e->getMessage());
        }        
    }

    // public function addRow(string $spreadsheet_id, int $columnIndex, string $sheetTitle)
    // {
    //     try {
    //         $spreadsheet = $this->services->spreadsheets->get($spreadsheet_id);
    //         $sheetId = null;

    //         foreach ($spreadsheet->getSheets() as $sheet) {
    //             if ($sheet->getProperties()->getTitle() === $sheetTitle) {
    //                 $sheetId = $sheet->getProperties()->getSheetId();
    //                 break;
    //             }
    //         }

    //         if ($sheetId === null) {
    //             \Log::error("Google Sheets API: Sheet '{$sheetTitle}' not found.");
    //             return;
    //         }

    //         // Sorting request (skip header row)
    //         $sortRequest = new \Google\Service\Sheets\Request([
    //             'sortRange' => [
    //                 'range' => [
    //                     'sheetId' => $sheetId,
    //                     'startRowIndex' => 1, // Skip header row
    //                     'startColumnIndex' => 0,
    //                     'endColumnIndex' => 7,
    //                 ],
    //                 'sortSpecs' => [
    //                     [
    //                         'dimensionIndex' => $columnIndex,
    //                         'sortOrder' => 'ASCENDING'
    //                     ]
    //                 ]
    //             ]
    //         ]);

    //         // Header Formatting (KEEP this as is, Blue Background)
    //         $headerFormatRequest = new \Google\Service\Sheets\Request([
    //             'repeatCell' => [
    //                 'range' => [
    //                     'sheetId' => $sheetId,
    //                     'startRowIndex' => 0, // Header row only
    //                     'endRowIndex' => 1,
    //                     'startColumnIndex' => 0,
    //                     'endColumnIndex' => 7,
    //                 ],
    //                 'cell' => [
    //                     'userEnteredFormat' => [
    //                         'textFormat' => [
    //                             'bold' => true,
    //                             'foregroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1] // White text
    //                         ],
    //                         'horizontalAlignment' => 'LEFT',
    //                         'backgroundColor' => ['red' => 0.26, 'green' => 0.53, 'blue' => 0.96] // Blue background (#4287f5)
    //                     ]
    //                 ],
    //                 'fields' => 'userEnteredFormat(textFormat, horizontalAlignment, backgroundColor)'
    //             ]
    //         ]);

    //         // Data Formatting (Reset to Default: REMOVE Background Color)
    //         $dataFormatRequest = new \Google\Service\Sheets\Request([
    //             'repeatCell' => [
    //                 'range' => [
    //                     'sheetId' => $sheetId,
    //                     'startRowIndex' => 1, // Data rows start from row 2
    //                     'startColumnIndex' => 0,
    //                     'endColumnIndex' => 7,
    //                 ],
    //                 'cell' => [
    //                     'userEnteredFormat' => [
    //                         'textFormat' => ['bold' => false], // Regular text
    //                         'horizontalAlignment' => 'LEFT' // Left-aligned text
    //                     ]
    //                 ],
    //                 'fields' => 'userEnteredFormat(textFormat, horizontalAlignment)' //
    //             ]
    //         ]);

    //         // Auto-Resize Columns
    //         $autoResizeRequest = new \Google\Service\Sheets\Request([
    //             'autoResizeDimensions' => [
    //                 'dimensions' => [
    //                     'sheetId' => $sheetId,
    //                     'dimension' => 'COLUMNS',
    //                     'startIndex' => 0,
    //                     'endIndex' => 7
    //                 ]
    //             ]
    //         ]);

    //         // Execute batch update
    //         $requestBody = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
    //             'requests' => [$sortRequest, $headerFormatRequest, $dataFormatRequest, $autoResizeRequest]
    //         ]);

    //         $this->services->spreadsheets->batchUpdate($spreadsheet_id, $requestBody);

    //         \Log::info("Sorting and header formatting applied successfully for '{$sheetTitle}'.");

    //     } catch (\Exception $e) {
    //         \Log::error('Google Sheets API Sort Error: ' . $e->getMessage());
    //     }        
    // }
}
