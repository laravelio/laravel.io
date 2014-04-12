<?php namespace Lio\Accounts;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
