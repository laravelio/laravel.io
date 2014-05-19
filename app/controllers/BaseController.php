<?php

use Lio\CommandBus\CommandBus;

abstract class BaseController extends Controller
{
    protected $layout = 'layouts.default';
    protected $title = '';

    protected $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    protected function render($path, $data = [])
    {
        View::share('currentUser', $this->auth->user());
        $this->layout->title = $this->title;
        $this->layout->content = View::make($path, $data);
    }

    protected function redirectIntended($default = null)
    {
        $intended = Session::get('auth.intended_redirect_url');
        if ($intended) {
            return Redirect::to($intended);
        }
        return Redirect::to($default);
    }
}
