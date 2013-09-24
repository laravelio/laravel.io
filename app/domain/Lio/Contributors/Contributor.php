<?php namespace Lio\Contributors;

use Lio\Core\EloquentBaseModel;

class Contributor extends EloquentBaseModel
{
    protected $table    = 'contributors';
    protected $fillable = ['user_id', 'github_id', 'name', 'avatar_url', 'github_url', 'contribution_count'];

    protected $validatorRules = [
        'github_id'          => 'required',
        'name'               => 'required',
        'contribution_count' => 'required',
    ];

    public function user()
    {
        return $this->belongsTo('Lio\Accounts\User', 'user_id');
    }

    public function setGithubIdAttribute($githubId)
    {
        $this->attributes['github_id'] = $githubId;

        $userRepository = \App::make('Lio\Accounts\UserRepository');
        $user = $userRepository->getByGithubId($githubId);
        if ( ! $user) return;
        $this->attributes['user_id'] = $user->id;
    }
}