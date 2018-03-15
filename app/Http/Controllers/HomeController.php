<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function show()
    {
        return view('home');
    }

    public function rules()
    {
        return view('rules');
    }

    public function terms()
    {
        return view('terms');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function pastebin(string $hash = '')
    {
        return redirect()->away("https://paste.laravel.io/$hash");
    }
}
