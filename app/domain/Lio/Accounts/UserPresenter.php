<?php namespace Lio\Accounts;

use McCool\LaravelAutoPresenter\BasePresenter;

class UserPresenter extends BasePresenter
{
    public function roleList()
    {
        $roles = $this->getRoles();

        if ( ! $roles->count()) {
            return "none";
        }

        $roleArray = [];

        foreach ($roles as $role) {
            $roleArray[] = $role->name;
        }

        return implode(', ', $roleArray);
    }

    public function profileUrl()
    {
        return action('Controllers\UsersController@getProfile', [$this->resource->name]);
    }
}