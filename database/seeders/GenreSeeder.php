<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info("Game genres loading started!");

        $snowflake = app('Kra8\Snowflake\Snowflake');

        // Open the file
        if (($handle = fopen(storage_path('app/private/datasets/genres.csv'), 'r')) !== false) {
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
                    'id' => (int) $row[0],
                    'name' => $row[2],
                    'slug' => $row[3],
                    'igdb_created' => Carbon::createFromFormat('n/j/Y', $row[1])->format('Y-m-d'),
                    'igdb_updated' => Carbon::createFromFormat('n/j/Y', $row[4])->format('Y-m-d'),
                    'igdb_url' => $row[5],
                    'igdb_checksum' => $row[6],
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

            Log::info("Game genres loaded successfully!");
        }
    }

    private function insertBatch($records)
    {
        DB::table('genres')->insert($records);
    }
}
