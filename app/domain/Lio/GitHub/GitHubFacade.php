<?php namespace Lio\GitHub;

use Illuminate\Support\Facades\Facade;

class GitHubFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'github'; }
}