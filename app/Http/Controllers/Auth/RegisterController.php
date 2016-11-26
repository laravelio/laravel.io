<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Jobs\SendEmailAddressConfirmation;
use App\Http\Controllers\Controller;
use App\Users\User;
use App\Users\UserRepository;
use App\Users\UserWasRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * @var \App\Users\UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        $this->middleware('guest');
    }

    public function redirectToRegistrationForm()
    {
        return redirect()->route('register', [], 301);
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, app(RegisterRequest::class)->rules());
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): User
    {
        $user = $this->users->create(app(RegisterRequest::class));

        $this->dispatchNow(new SendEmailAddressConfirmation($user));

        return $user;
    }
}
