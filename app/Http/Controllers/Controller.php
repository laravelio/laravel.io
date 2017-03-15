<?php

namespace Lio\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Redirect;
use Session;

class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected function redirectTo($url, $statusCode = 302)
    {
        return Redirect::to($url, $statusCode);
    }

    protected function redirectAction($action, $data = [])
    {
        return Redirect::action($action, $data);
    }

    protected function redirectRoute($route, $data = [])
    {
        return Redirect::route($route, $data);
    }

    protected function redirectBack($data = [], $input = [])
    {
        return Redirect::back()->withInput($input)->with($data);
    }

    protected function redirectIntended($default = null)
    {
        if ($intended = Session::get('auth.intended_redirect_url')) {
            return $this->redirectTo($intended);
        }

        return Redirect::to($default);
    }
}
