<?php

namespace Lio\Accounts;

use Lio\Core\Entity;

class Role extends Entity
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    protected $validationRules = [
        'name' => 'required',
    ];

    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
