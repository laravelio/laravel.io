<?php namespace Lio\Accounts;

/**
* This class can call the following methods on the observer object:
*
* userValidationError($validator->getErrors())
* userSuccessfullyCreated($user)
*/
class UserCreator
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function create($observer, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $observer->userValidationError($validator->getErrors());
        }
        return $this->createValidUserRecord($observer, $data);
    }

    private function createValidUserRecord($observer, $data)
    {
        $user = $this->users->getNew($data);

        // check the model validation
        if ( ! $this->users->save($user)) {
            return $observer->userValidationError($user->getErrors());
        }

        return $observer->userSuccessfullyCreated($user);
    }
}