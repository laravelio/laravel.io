<?php

namespace Lio\Accounts;

use McCool\LaravelAutoPresenter\BasePresenter;

class UserPresenter extends BasePresenter
{
    public function roleList()
    {
        $roles = $this->roles;

        if (!$roles->count()) {
            return 'none';
        }

        $roleArray = [];

        foreach ($roles as $role) {
            $roleArray[] = $role->name;
        }

        return implode(', ', $roleArray);
    }

    public function profileUrl()
    {
        return action('UsersController@getProfile', [$this->getWrappedObject()->name]);
    }

    public function thumbnail()
    {
        return '<img src="'.$this->image_url.'&size=50" alt="'.$this->getWrappedObject()->name.'">';
    }

    public function imageMedium()
    {
        return '<img src="'.$this->image_url.'&size=300">';
    }
}
