<?php namespace Lio\Accounts;

use Lio\Core\EloquentBaseModel;

class Role extends EloquentBaseModel
{
    protected $table = 'roles';

    protected $fillable = ['name', 'description'];

    protected $validationRules = [
        'name' => 'required|exists:roles,<name>',
    ];

    public function users()
    {
        $this->belongsToMany('Lio\Accounts\User');
    }
}
