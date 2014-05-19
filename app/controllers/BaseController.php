<?php

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Session\SessionManager;
use Illuminate\View\Factory;
use Lio\CommandBus\CommandBus;

abstract class BaseController extends Controller
{
    protected $layout = 'layouts.default';
    protected $title = '';

    protected $bus;
    protected $request;
    protected $redirector;
    protected $session;
    /**
     * @var Illuminate\View\Factory
     */
    private $view;
    /**
     * @var Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(CommandBus $bus, Request $request, Redirector $redirector, SessionManager $session, Factory $view, AuthManager $auth)
    {
        $this->bus = $bus;
        $this->request = $request;
        $this->redirector = $redirector;
        $this->session = $session;
        $this->view = $view;
        $this->auth = $auth;
    }

    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = $this->view->make($this->layout);
        }
    }

    protected function render($path, $data = [])
    {
        $this->view->share('currentUser', $this->auth->user());
        $this->layout->title = $this->title;
        $this->layout->content = $this->view->make($path, $data);
    }

    protected function redirectIntended($default = null)
    {
        $intended = $this->session->get('auth.intended_redirect_url');
        if ($intended) {
            return $this->redirector->to($intended);
        }
        return $this->redirector->to($default);
    }
}
