<?php

namespace App\Http\Controllers;

use App\Tags\Tag;
use App\Tags\TagRepository;

class TagsController extends Controller
{
    public function overview(TagRepository $tags)
    {
        return view('tags.overview', ['tags' => $tags->findAll()]);
    }

    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }
}
