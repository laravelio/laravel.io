<?php namespace Lio\Accounts;

/**
* This class can call the following methods on the observer object:
*
* userValidationError($errors)
* userCreated($user)
*/
class UserCreator
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function create(UserCreatorListener $listener, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $listener->userValidationError($validator->getErrors());
        }

        return $this->createValidUserRecord($listener, $data);
    }

    private function createValidUserRecord($listener, $data)
    {
        $user = $this->users->getNew($data);

        // check the model validation
        if (! $this->users->save($user)) {
            return $listener->userValidationError($user->getErrors());
        }

        return $listener->userCreated($user);
    }
}