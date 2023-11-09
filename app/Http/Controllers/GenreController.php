<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genre = Genre::all();
        return Inertia::render('Genre/Index', [
            'genre' => $genre
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Genre/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Genre::create([
            'name' => $request->name
        ]);
        return redirect()->route('genre.index')->with('message', 'Genre Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return Inertia::render('Genre/Edit', [
            "genre" => $genre
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $genre->name = $request->name;

        $genre->save();

        return redirect()->route('genre.index')->with('message', 'genre edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('genre.index')->with('message', "Genre Deleted");
    }
}
