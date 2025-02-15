<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

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
        dd($game->name);
    }

    public function addFav($slug, Request $request): RedirectResponse
    {
        $id = explode('-', $slug)[0];
        $game = Game::where('igdb_id', (int) $id)->firstOrFail();

        $request->user()->favGames()->attach($game);
        return redirect(route('dashboard'));
    }

    public function dashboard(Request $request): Response
    {
        $query = $request->input('query');
        $favGames = $request->user()->favGames;

        if(strlen($query) < 3) {
            $searchResults = [];
        } else {
            $searchResults = Game::search($query)->whereIn(
                'category', [0, 1]
            )->get();

        }

        return Inertia::render('Dashboard', [
            'search_games' => $searchResults,
            'fav_games' => $favGames,
        ]);
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
