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
        $client->setAuthConfig(storage_path('app/hackz-decoder-cdd44504680d.json'));
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
}
