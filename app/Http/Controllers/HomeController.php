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
}
