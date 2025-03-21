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
    public function rows(string $spreadsheet_id, string $range, array $data)
    {
        $body = new Sheets\ValueRange(['values' => $data]);

        $parameters = [
            'valueInputOption' => 'RAW',
            'insertDataOption' => 'INSERT_ROWS',
        ];

        return $this->services->spreadsheets_values->append($spreadsheet_id, $range, $body, $parameters);
    }

    /**
     * Sorts the Google Sheet in descending order based on a given column.
     *
     * @param string $spreadsheet_id The ID of the Google Sheet.
     * @param int $columnIndex The index of the column to sort by (0-based).
     * @return void
     */
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
    
    //         // Get existing sheet data
    //         $sheetData = $this->services->spreadsheets_values->get($spreadsheet_id, $sheetTitle);
    //         $values = $sheetData->getValues();
    //         $rowCount = count($values);
    
    //         $requests = [];
    
    //         // Check if header exists (assuming header row is not empty)
    //         $headerExists = $rowCount > 0 && !empty(array_filter($values[0]));
    
    //         if (!$headerExists) {
    //             // Insert Header Row
    //             $headerValues = [["Column 1", "Column 2", "Column 3", "Column 4", "Column 5", "Column 6", "Column 7"]];
    //             $requests[] = new \Google\Service\Sheets\Request([
    //                 'updateCells' => [
    //                     'rows' => [['values' => array_map(fn($val) => ['userEnteredValue' => ['stringValue' => $val]], $headerValues[0])]],
    //                     'fields' => 'userEnteredValue',
    //                     'start' => ['sheetId' => $sheetId, 'rowIndex' => 0, 'columnIndex' => 0]
    //                 ]
    //             ]);
    
    //             // Apply header formatting
    //             $requests[] = new \Google\Service\Sheets\Request([
    //                 'repeatCell' => [
    //                     'range' => ['sheetId' => $sheetId, 'startRowIndex' => 0, 'endRowIndex' => 1, 'startColumnIndex' => 0, 'endColumnIndex' => 7],
    //                     'cell' => ['userEnteredFormat' => ['textFormat' => ['bold' => true, 'foregroundColor' => ['red' => 1, 'green' => 1, 'blue' => 1]], 'horizontalAlignment' => 'LEFT', 'backgroundColor' => ['red' => 0.26, 'green' => 0.53, 'blue' => 0.96]]],
    //                     'fields' => 'userEnteredFormat(textFormat, horizontalAlignment, backgroundColor)'
    //                 ]
    //             ]);
    
    //             // Increase row count after inserting header
    //             $rowCount = 1;
    //         }
    
    //         // Always place the merged row **directly below the header**
    //         $mergedRowIndex = 1;
    
    //         // Insert a new row at index 1 (right below the header)
    //         $requests[] = new \Google\Service\Sheets\Request([
    //             'insertDimension' => [
    //                 'range' => ['sheetId' => $sheetId, 'dimension' => 'ROWS', 'startIndex' => $mergedRowIndex, 'endIndex' => $mergedRowIndex + 1],
    //                 'inheritFromBefore' => false
    //             ]
    //         ]);
    
    //         // Merge the new row
    //         $requests[] = new \Google\Service\Sheets\Request([
    //             'mergeCells' => [
    //                 'range' => ['sheetId' => $sheetId, 'startRowIndex' => $mergedRowIndex, 'endRowIndex' => $mergedRowIndex + 1, 'startColumnIndex' => 0, 'endColumnIndex' => 7],
    //                 'mergeType' => 'MERGE_ALL'
    //             ]
    //         ]);
    
    //         // Insert current date into the merged row and center align
    //         $requests[] = new \Google\Service\Sheets\Request([
    //             'repeatCell' => [
    //                 'range' => ['sheetId' => $sheetId, 'startRowIndex' => $mergedRowIndex, 'endRowIndex' => $mergedRowIndex + 1, 'startColumnIndex' => 0, 'endColumnIndex' => 1],
    //                 'cell' => ['userEnteredValue' => ['stringValue' => date('Y-m-d')], 'userEnteredFormat' => ['horizontalAlignment' => 'CENTER']],
    //                 'fields' => 'userEnteredValue, userEnteredFormat(horizontalAlignment)'
    //             ]
    //         ]);
    
    //         // Auto-Resize Columns
    //         $requests[] = new \Google\Service\Sheets\Request([
    //             'autoResizeDimensions' => [
    //                 'dimensions' => ['sheetId' => $sheetId, 'dimension' => 'COLUMNS', 'startIndex' => 0, 'endIndex' => 7]
    //             ]
    //         ]);
    
    //         // Execute batch update
    //         $requestBody = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest(['requests' => $requests]);
    //         $this->services->spreadsheets->batchUpdate($spreadsheet_id, $requestBody);
    
    //         \Log::info("Merged date row applied directly below the header for '{$sheetTitle}'.");
    
    //     } catch (\Exception $e) {
    //         \Log::error('Google Sheets API Error: ' . $e->getMessage());
    //     }        
    // }

    public function addRow(string $spreadsheet_id, int $columnIndex, string $sheetTitle, array $jsonData)
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

        // Get existing sheet data
        $sheetData = $this->services->spreadsheets_values->get($spreadsheet_id, $sheetTitle);
        $values = $sheetData->getValues();
        $rowCount = count($values);

        // ✅ Ensure header row exists (Row 1)
        if ($rowCount === 0 || empty($values[0])) {
            $headerValues = [["Column 1", "Column 2", "Column 3", "Column 4", "Column 5", "Column 6", "Column 7"]];
            $this->services->spreadsheets_values->update(
                $spreadsheet_id,
                "{$sheetTitle}!A1:G1",
                new \Google\Service\Sheets\ValueRange(['values' => $headerValues]),
                ['valueInputOption' => 'RAW']
            );
            $rowCount = 1;
        }

        // ✅ Ensure merged row exists at Row 2
        if (!isset($values[1]) || count($values[1]) !== 1) {
            $batchRequests = [
                [
                    'mergeCells' => [
                        'range' => ['sheetId' => $sheetId, 'startRowIndex' => 1, 'endRowIndex' => 2, 'startColumnIndex' => 0, 'endColumnIndex' => 7],
                        'mergeType' => 'MERGE_ALL'
                    ]
                ],
                [
                    'repeatCell' => [
                        'range' => ['sheetId' => $sheetId, 'startRowIndex' => 1, 'endRowIndex' => 2, 'startColumnIndex' => 0, 'endColumnIndex' => 1],
                        'cell' => ['userEnteredValue' => ['stringValue' => date('Y-m-d')], 'userEnteredFormat' => ['horizontalAlignment' => 'CENTER']],
                        'fields' => 'userEnteredValue, userEnteredFormat(horizontalAlignment)'
                    ]
                ]
            ];

            // Execute batch update for merged row
            $this->services->spreadsheets->batchUpdate($spreadsheet_id, new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $batchRequests
            ]));

            $rowCount = 2; // Ensure rowCount is updated
        }

        // ✅ Convert JSON data to array format expected by Google Sheets
        $newRows = [];
        foreach ($jsonData as $item) {
            $newRows[] = [
                $item['column1'] ?? '',
                $item['column2'] ?? '',
                $item['column3'] ?? '',
                $item['column4'] ?? '',
                $item['column5'] ?? '',
                $item['column6'] ?? '',
                $item['column7'] ?? '',
            ];
        }

        // ✅ Insert new rows **starting at Row 3**
        if (!empty($newRows)) {
            $range = "{$sheetTitle}!A3:G"; // Force starting from Row 3

            $this->services->spreadsheets_values->append(
                $spreadsheet_id,
                $range,
                new \Google\Service\Sheets\ValueRange(['values' => $newRows]),
                ['valueInputOption' => 'RAW']
            );
        }

        \Log::info("Header and merged row verified. JSON data inserted after merged row.");

    } catch (\Exception $e) {
        \Log::error('Google Sheets API Error: ' . $e->getMessage());
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
