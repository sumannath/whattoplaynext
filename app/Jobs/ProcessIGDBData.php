<?php

namespace App\Jobs;

use App\Models\Game;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessIGDBData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get the static query file
        $staticQuery = file_get_contents(storage_path('app/private/query.txt'));

        $MAX_OFFSET = 330000;
        $offset = 0;
        $limit = 100;
        while(offset <= MAX_OFFSET) {
            $response = Http::withHeaders([
                'Client-ID' => env('IGDB_CLIENT_ID'),
                "Authorization" => "Bearer ".env('IGDB_ACCESS_TOKEN'),
                "Content-Type" => "application/json",
            ])->withBody(
                "$staticQuery limit $limit; offset $offset;"
            )->post('https://api.igdb.com/v4/games');

            if($response->ok()) {
                $gameData = json_decode($response->body());
                foreach($game )

                usleep(250000);
                $offset += $limit;
            } else {
                Log::error("Response failed");
                Log::error($response);
            }

        }
    }
}
