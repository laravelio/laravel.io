<?php namespace Lio\Accounts;

use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

class UserUpdater
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
     * @param \Lio\Accounts\UserRepository $users
     * @param \Lio\Accounts\SendConfirmationEmail $confirmation
     */
    public function __construct(UserRepository $users, SendConfirmationEmail $confirmation)
    {
        $this->users = $users;
        $this->confirmation = $confirmation;
    }

    /**
     * @param \Lio\Accounts\UserUpdaterListener $listener
     * @param \Lio\Accounts\User $user
     * @param array $data
     * @param \Illuminate\Validation\Validator $validator
     * @return mixed
     */
    public function update(UserUpdaterListener $listener, User $user, array $data, Validator $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $listener->userValidationError($validator->getErrors());
        }

        return $this->updateUser($user, $listener, $data);
    }

    /**
     * @param \Lio\Accounts\User $user
     * @param \Lio\Accounts\UserUpdaterListener $listener
     * @param array $data
     * @return mixed
     */
    private function updateUser(User $user, UserUpdaterListener $listener, array $data)
    {
        $oldEmail = $user->email;

        $user->fill($data);

        // If the email changed, the user will need to re-confirm it.
        if ($data['email'] !== $oldEmail) {
            $user->confirmed = false;

            // Set a confirmation code for the user. He'll need to verify his email address
            // with this code before he can use certain sections on the website.
            $confirmationCode = Str::random(30);

            // We'll generate a new one if we find a user with the same code.
            while ($this->users->getByConfirmationCode($confirmationCode) !== null) {
                $confirmationCode = Str::random(30);
            }

            $user->confirmation_code = $confirmationCode;
        }

        // check the model validation
        if (! $this->users->save($user)) {
            return $listener->userValidationError($user->getErrors());
        }

        // Send a confirmation email to the user.
        if ($data['email'] !== $oldEmail) {
            $this->confirmation->send($user);
        }

        return $listener->userUpdated($user, $data['email'] !== $oldEmail);
    }
}