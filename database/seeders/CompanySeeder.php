<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info("Game companies loading started!");

        $snowflake = app('Kra8\Snowflake\Snowflake');

        // Open the file
        if (($handle = fopen(storage_path('app/private/datasets/companies.csv'), 'r')) !== false) {
            // Skip the header row
            fgetcsv($handle);

            // Initialize a batch array for bulk insert
            $batch = [];
            $batchSize = 1000; // Number of records to insert at once

            // Read the data rows
            while (($row = fgetcsv($handle)) !== false) {
                // Map CSV columns to database fields
                // Modify this array according to your CSV structure and table fields
                $record = [
                    'id' => (int) $row[1],
                    'name' => $row[8],
                    'slug' => $row[9],
                    'country_id' => $row[3] == ''? NULL: (int) $row[3],
                    'description' => $row[5],
                    'igdb_created' => Carbon::createFromFormat('U', $row[4])->format('Y-m-d'),
                    'igdb_updated' => Carbon::createFromFormat('U', $row[12])->format('Y-m-d'),
                    'igdb_url' => $row[13],
                    'igdb_checksum' => $row[15],
                    'igdb_logo_id' => $row[7] == ''? NULL: (int) $row[7],
                    'igdb_parent_id' => $row[17] == ''? NULL: (int) $row[17],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];

                // Add record to batch
                $batch[] = $record;

                // When batch size is reached, insert and reset batch
                if (count($batch) >= $batchSize) {
                    $this->insertBatch($batch);
                    $batch = [];
                }
            }

            // Insert any remaining records
            if (!empty($batch)) {
                $this->insertBatch($batch);
            }

            fclose($handle);

            Log::info("Game companies loaded successfully!");
        }
    }

    private function insertBatch($records)
    {
        DB::table('companies')->insert($records);
    }
}
