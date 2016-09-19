<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Users\NewUserData;
use App\Users\SendEmailAddressConfirmation;
use App\Users\User;
use App\Users\UserRepository;
use App\Users\UserWasRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;
use Validator;

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
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:40|unique:users',
        ];

        if (Session::has('githubData')) {
            $rules['password'] = 'confirmed|min:6';
        } else {
            $rules['password'] = 'required|confirmed|min:6';
        }

        if (! app()->runningUnitTests()) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): User
    {
        $user = $this->users->create(new NewUserData(
            $data['name'],
            $data['email'],
            $data['username'],
            ! request()->has('github_id') ? bcrypt($data['password']) : null,
            request()->ip(),
            request('github_id')
        ));

        $this->dispatchNow(new SendEmailAddressConfirmation($user));

        return $user;
    }
}
