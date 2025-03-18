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
    public function sortSheet(string $spreadsheet_id, int $columnIndex, string $sheetTitle)
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
                    'fields' => 'userEnteredFormat(textFormat, horizontalAlignment)' //
                ]
            ]);

            // ✅ Auto-Resize Columns
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

            // Execute batch update
            $requestBody = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => [$sortRequest, $headerFormatRequest, $dataFormatRequest, $autoResizeRequest]
            ]);

            $this->services->spreadsheets->batchUpdate($spreadsheet_id, $requestBody);

            \Log::info("Sorting and header formatting applied successfully for '{$sheetTitle}'.");

        } catch (\Exception $e) {
            \Log::error('Google Sheets API Sort Error: ' . $e->getMessage());
        }
    }
}
