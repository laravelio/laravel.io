<?php
namespace Lio\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
