<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Session\SessionManager;
use Lio\CommandBus\CommandBus;

abstract class BaseController extends Controller
{
    protected $layout = 'layouts.default';
    protected $title = '';

    protected $bus;
    protected $request;
    protected $redirector;
    protected $session;

    public function __construct(CommandBus $bus, Request $request, Redirector $redirector, SessionManager $session)
    {
        $this->bus = $bus;
        $this->request = $request;
        $this->redirector = $redirector;
        $this->session = $session;
    }

    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    protected function renderView($path, $data = [])
    {
        View::share('currentUser', Auth::user());
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
