<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImage;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::latest()->get();
        return Inertia::render(
            'Image/Index',
            ['images' => $images]
        );
    }
    public function create()
    {
        return Inertia::render('Image/Create');
    }
    public function store(Image $image, Request $request)
    {

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $image_path = '';
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('public/image');
        }
        // $image_path = $request->file('image')->store('public', 'image');
        // dd($image_path);

        Image::create([
            'image' => $image_path,
        ]);
        sleep(1);

        // if ($request->hasFile('image')) {
        //     $request->validate([
        //         'image.*' => 'mimes:jpg,png,jpeg,webp|max:5000'
        //     ], [
        //         'image.*.mimes' => 'The file should be in one of the formats: jpg, png, jpeg, webp'
        //     ]);

        //     foreach ($request->file('image') as $file) {
        //         $path = $file->store('public/images');

        //         Image::create(['image' => $path]);
        //     }
        // }
        return redirect()->route('image.index')->with('message', 'Image Uploaded Successfully');
    }
}
