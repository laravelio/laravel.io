<?php namespace Lio\Accounts;

use Illuminate\Database\Eloquent\Model;

interface MemberRepository
{
    public function getById($id);
    public function getByGithubId($id);
    public function requireByName($name);
    public function getByName($name);
    public function save(Model $member);
}
