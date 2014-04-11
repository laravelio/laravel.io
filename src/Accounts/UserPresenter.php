<?php namespace Lio\Accounts;

use HTML;
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
        return action('ProfileController@getShow', [$this->resource->name]);
    }

    public function thumbnail()
    {
        return HTML::image($this->image_url . "&size=50", $this->resource->name);
    }

    public function imageMedium()
    {
        return HTML::image($this->image_url . "&size=300");
    }
}
