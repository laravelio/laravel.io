<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

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

    public function redirectToPaste()
    {
        return Redirect::to('https://paste.laravel.io');
    }
}
