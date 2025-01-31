<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info("Game categories loading started!");

        $snowflake = app('Kra8\Snowflake\Snowflake');

        // Open the file
        if (($handle = fopen(storage_path('app/private/datasets/category_mapping.csv'), 'r')) !== false) {
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
                    'description' => $row[1],
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

            Log::info("Game categories loaded successfully!");
        }
    }

    private function insertBatch($records)
    {
        DB::table('categories')->insert($records);
    }
}
