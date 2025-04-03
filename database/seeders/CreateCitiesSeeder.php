<?php

namespace Database\Seeders;

use App\Models\cities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CreateCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Starting the seeding process for cities.');

        $filePath = base_path('database/Data/zipcodes.csv');
        Log::info("Reading CSV file from path: {$filePath}");

        $cities = $this->readCsv($filePath);

        if ($cities) {
            Log::info('CSV file read successfully. Formatting data for insertion.');

            $formattedCities = array_map(function ($city) {
                return [
                    'Plaatsnaam' => $city['Plaatsnaam'],
                    'Postcode' => $city['Postcode'],
                    'Provincie' => $city['Provincie'],
                ];
            }, $cities);

            Log::info('Inserting data into the cities table.', ['count' => count($formattedCities)]);
            //DB::table('cities')->insert($formattedCities);
            foreach ($formattedCities as $cities) {
                Cities::create($cities);
            }
            Log::info('Data inserted successfully.');
        } else {
            Log::warning('No data found in the CSV file or the file could not be read.');
        }
    }

    /**
     * Read a CSV file and return an array of data.
     */
    private function readCsv(string $filePath, string $delimiter = ';', bool $hasHeaders = true): array
    {
        $data = [];
        if (!file_exists($filePath) || !is_readable($filePath)) {
            Log::error("File does not exist or is not readable: {$filePath}");
            return $data;
        }

        $fileHandle = fopen($filePath, 'r');
        if ($hasHeaders) {
            $headers = fgetcsv($fileHandle, 0, $delimiter);
            Log::info('CSV headers read successfully.', ['headers' => $headers]);
        }

        while (($row = fgetcsv($fileHandle, 0, $delimiter)) !== false) {
            if ($hasHeaders) {
                $data[] = array_combine($headers, $row);
            } else {
                $data[] = $row;
            }
        }

        fclose($fileHandle);
        Log::info('CSV file read and parsed successfully.', ['rowCount' => count($data)]);

        return $data;
    }
}
