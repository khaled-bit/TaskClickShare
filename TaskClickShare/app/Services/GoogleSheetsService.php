<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Sheets;

class GoogleSheetsService
{
    protected $client;
    protected $service;
    protected $spreadsheetId = '1CybQUTIex-Tejpo3qt-a8TTeq0VzfOg4FekWeu2xdl8';

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setApplicationName('Google Sheets and Laravel Integration');
        $this->client->setScopes([Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(storage_path(env('GOOGLE_SHEETS_CREDENTIALS_PATH')));
        $this->service = new Sheets($this->client);
    }

    public function fetchSheetData($range)
    {
        try {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
            return $response->getValues();
        } catch (\Exception $e) {

            throw new \Exception("Error fetching data from Google Sheets: " . $e->getMessage());
        }
    }
    public function listSheets()
    {
        $spreadsheet = $this->service->spreadsheets->get($this->spreadsheetId);
        $sheets = $spreadsheet->getSheets();

        foreach ($sheets as $sheet) {
            $title = $sheet['properties']['title'];
            $rowCount = $sheet['properties']['gridProperties']['rowCount'];
            $columnCount = $sheet['properties']['gridProperties']['columnCount'];
            $range = "$title!A1:" . chr(65 + $columnCount - 1) . "$rowCount";

            echo "Sheet Name: $title, Range: $range\n";

            $values = $this->fetchSheetData($range);
            foreach ($values as $row) {
                echo implode("\t", $row) . "\n";
            }
            echo "\n";
        }
    }
}
