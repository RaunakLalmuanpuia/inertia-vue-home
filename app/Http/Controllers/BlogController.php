<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __invoke(Request $request)
    // {
    //     $searchOptions = $request->input('search_options', []);
    //     $globalSearch = AllowedFilter::callback('global', function ($query, $value) use ($searchOptions) {
    //         $query->where(function ($query) use ($value, $searchOptions) {
    //             Collection::wrap($searchOptions)->each(function ($option) use ($value, $query) {
    //                 $query->orWhere($option, 'LIKE', '%' . $value . '%');
    //             });
    //         });
    //     });

    //     $blogs  = QueryBuilder::for(Blog::class)->defaultSort('tile', 'id', 'created_at')
    //         ->allowedSorts(['id', 'title', 'created_at'])->allowedFilters(['id', 'title', 'created_at', $globalSearch])
    //         ->withQueryString();

    //     return Inertia::render('Blogs/Index', ['blogs' => $blogs])->items();
    // }


    public function index()
    {
        $blogs = Blog::all();
        return Inertia::render('Blogs/Index', [
            'blogs' => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Blogs/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required'
        ]);
        Blog::create([
            'title' => $request->title,
            'content' => $request->content
        ]);
        sleep(1);
        return redirect()->route('blogs.index')->with('message', 'Blog Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return Inertia::render('Blogs/Edit', [
            'blog' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required'
        ]);
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();

        return redirect()->route('blogs.index')->with('message', 'Blog Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blogs.index')->with('message', 'Blog Deleted Succesfully');
    }
}
