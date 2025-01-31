<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $searchResults = Game::search($query)->whereIn(
            'category', [0, 1]
        )->get();

        return response()->json($searchResults);

        // // Extract IDs from the hits
        // $ids = collect($searchResults['hits'])->pluck('igdb_id')->toArray();


        // // Ensure you're using the correct query syntax for MongoDB
        // $fullModels = Game::whereIn('igdb_id', $ids)->get()
        //     ->sortBy(fn($model) => array_search($model->id, $ids))
        //     ->values();

        //     return response()->json([
        //         'hits' => $fullModels,
        //     ]);
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
