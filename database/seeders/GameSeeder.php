<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info("Game loading started!");

        $snowflake = app('Kra8\Snowflake\Snowflake');

        // Open the file
        if (($handle = fopen(storage_path('app/private/datasets/games.csv'), 'r')) !== false) {
            // Skip the header row
            fgetcsv($handle);

            // Initialize a batch array for bulk insert
            $batch = [];
            $genreBatch = [];
            $platformBatch = [];
            $similarGameBatch = [];
            $batchSize = 1000; // Number of records to insert at once

            // Read the data rows
            while (($row = fgetcsv($handle)) !== false) {
                // Map CSV columns to database fields
                // Modify this array according to your CSV structure and table fields
                $record = [
                    'id' => (int) $row[1],
                    'category_id' => (int) $row[2],
                    'name' => $row[8],
                    'slug' => $row[13],
                    'first_release_date' => $row[5] == ''? NULL : Carbon::createFromFormat('U', $row[5])->format('Y-m-d'),
                    'summary' => $row[15],
                    'igdb_created' => Carbon::createFromFormat('U', $row[3])->format('Y-m-d'),
                    'igdb_updated' => Carbon::createFromFormat('U', $row[18])->format('Y-m-d'),
                    'igdb_url' => $row[19],
                    'storyline' => $row[29],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];

                //Game Genres records
                if($row[7] != '') {
                    $array = explode(',', trim($row[7], '[]'));
                    $genre_ids = array_map('intval', array_map('trim', $array));
                    foreach ($genre_ids as $genre_id) {
                        $gameGenreRecord = [
                            'game_id' => $record['id'],
                            'genre_id' => $genre_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                        $genreBatch[] = $gameGenreRecord;
                    }
                }

                //Game platform records
                if($row[9] != '') {
                    $array = explode(',', trim($row[9], '[]'));
                    $platform_ids = array_map('intval', array_map('trim', $array));
                    foreach ($platform_ids as $platform_id) {
                        $gamePlatformRecord = [
                            'game_id' => $record['id'],
                            'platform_id' => $platform_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                        $platformBatch[] = $gamePlatformRecord;
                    }
                }

                //Similar game records
                if($row[12] != '') {
                    $array = explode(',', trim($row[12], '[]'));
                    $similar_game_ids = array_map('intval', array_map('trim', $array));
                    foreach ($similar_game_ids as $similar_game_id) {
                        $similarGameRecord = [
                            'game_id' => $record['id'],
                            'similar_game_id' => $similar_game_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                        $similarGameBatch[] = $similarGameRecord;
                    }
                }

                // Add record to batch
                $batch[] = $record;

                // When batch size is reached, insert and reset batch
                if (count($batch) >= $batchSize) {
                    $this->insertBatch($batch, $genreBatch, $platformBatch, $similarGameBatch);
                    $batch = [];
                    $genreBatch = [];
                    $platformBatch = [];
                    $similarGameBatch = [];
                }
            }

            // Insert any remaining records
            if (!empty($batch)) {
                $this->insertBatch($batch, $genreBatch, $platformBatch, $similarGameBatch);
            }

            fclose($handle);

            Log::info("Game companies loaded successfully!");
        }
    }

    private function insertBatch($records, $genreRecords, $platformRecords, $similarGameBatch)
    {
        DB::table('games')->insert($records);
        DB::table('game_genres')->insert($genreRecords);
        DB::table('game_platforms')->insert($platformRecords);
        DB::table('similar_games')->insert($similarGameBatch);
    }
}
