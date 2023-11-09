<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        //All user with role employee
        $usersWithRole = Role::where('name', 'employee')->first()->users;
        // Or if you prefer using the role name directly:

        // $usersWithRole = User::role('employee')->get();

        $book = Book::with(['author', 'genre'])->get();
        // $author = Author::all();
        // $genre = Genre::all();
        return Inertia::render('Book/Index', [
            'book' => $book,
            'role' => $usersWithRole
            // 'author' => $author,
            // 'genre' => $genre,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Author $author, Genre $genre)
    {
        $author = $author->all();
        $genre = $genre->all();

        return Inertia::render('Book/Create', [
            'author' => $author,
            'genre' => $genre,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'genre_id' => $request->genre_id,
        ]);
        // $books->author()->save([
        //     'author_id' => $request->author_id,
        // ]);
        // $books->genres()->save([
        //     'genre_id' => $request->genre_id,
        // ]);

        return redirect()->route('books.index')->with('message', 'books created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book, Author $author, Genre $genre)
    {
        $author = $author->all();
        $genre = $genre->all();

        return Inertia::render('Book/Edit', [
            'book' => $book,
            'author' => $author,
            'genre' => $genre,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->genre_id = $request->genre_id;

        $book->save();

        return redirect()->route('books.index')->with('message', 'books Edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('message', 'books Deleted');
    }
}
