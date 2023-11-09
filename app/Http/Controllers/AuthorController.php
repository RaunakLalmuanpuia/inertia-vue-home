<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $author = Author::all();
        return Inertia::render('Author/Index', [
            'author' => $author
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Author/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required'
        ]);


        Author::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address
        ]);
        return redirect()->route('author.index')->with('message', 'Author Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return Inertia::render('Author/Edit', [
            'author' => $author
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required'
        ]);
        $author->name = $request->name;
        $author->email = $request->email;
        $author->address = $request->address;

        $author->save();

        return redirect()->route('author.index')->with('message', 'Author Edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('author.index')->with('message', 'Author Deleted');
    }
}
