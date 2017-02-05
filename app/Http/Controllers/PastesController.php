<?php
namespace Lio\Http\Controllers;

use Auth;
use Input;

class PastesController extends Controller
{
    public function getShow($hash)
    {
        return redirect('http://paste.laravel.io/'.$hash);
    }

    public function getCreate()
    {
        return redirect('http://paste.laravel.io/');
    }

    public function getFork($hash)
    {
        return redirect('http://paste.laravel.io/fork/'.$hash);
    }

    public function getRaw($hash)
    {
        return redirect('http://paste.laravel.io/'.$hash.'/raw');
    }
}
