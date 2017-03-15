<?php

namespace Lio\Accounts;

use Illuminate\Support\Str;

/**
 * This class can call the following methods on the observer object:.
 *
 * userValidationError($errors)
 * userCreated($user)
 */
class UserCreator
{
    /**
     * @var \Lio\Accounts\UserRepository
     */
    protected $users;

    /**
     * @var \Lio\Accounts\SendConfirmationEmail
     */
    protected $confirmation;

    /**
     * @param \Lio\Accounts\UserRepository        $users
     * @param \Lio\Accounts\SendConfirmationEmail $confirmation
     */
    public function __construct(UserRepository $users, SendConfirmationEmail $confirmation)
    {
        $this->users = $users;
        $this->confirmation = $confirmation;
    }

    public function create(UserCreatorListener $listener, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && !$validator->isValid()) {
            return $listener->userValidationError($validator->getErrors());
        }

        return $this->createValidUserRecord($listener, $data);
    }

    private function createValidUserRecord($listener, $data)
    {
        $user = $this->users->getNew($data);

        // Set a confirmation code for the user. He'll need to verify his email address
        // with this code before he can use certain sections on the website.
        $confirmationCode = Str::random(30);

        // We'll generate a new one if we find a user with the same code.
        while ($this->users->getByConfirmationCode($confirmationCode) !== null) {
            $confirmationCode = Str::random(30);
        }

        $user->confirmation_code = $confirmationCode;

        // check the model validation
        if (!$this->users->save($user)) {
            return $listener->userValidationError($user->getErrors());
        }

        // Send a confirmation email to the user.
        $this->confirmation->send($user);

        return $listener->userCreated($user);
    }
}
