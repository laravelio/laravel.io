<?php

namespace App\Http\Controllers;

use App\Tags\Tag;

class TagsController extends Controller
{
    public function overview()
    {
        return view('tags.overview', ['tags' => Tag::all()]);
    }

    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }
}
