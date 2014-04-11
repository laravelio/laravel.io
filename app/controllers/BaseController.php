<?php

abstract class BaseController extends Controller
{
    protected $layout = 'layouts.default';
    protected $title = '';

    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    protected function view($path, $data = [])
    {
        View::share('currentUser', $this->currentUser);

        $this->layout->title = $this->title;
        $this->layout->content = View::make($path, $data);
    }

    protected function redirectIntended($default = null)
    {
        $intended = Session::get('auth.intended_redirect_url');
        if ($intended) {
            return $this->redirectTo($intended);
        }
        return Redirect::to($default);
    }
}
