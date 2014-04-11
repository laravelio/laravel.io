<?php namespace Lio\Accounts;

class Role extends \Eloquent
{
    protected $table = 'roles';

    protected $fillable = ['name', 'description'];

    protected $validationRules = [
        'name' => 'required',
    ];

    public function users()
    {
        $this->belongsToMany('Lio\Accounts\User');
    }
}
