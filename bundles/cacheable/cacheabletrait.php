<?php

trait CacheableTrait
{
    protected $cache = array();

    public function request_cache($key, \Closure $closure)
    {
        // return the cache if it exists
        if(!isset($this->cache[$key]))
        {
            $this->cache[$key] = $closure();
        }

        return $this->cache[$key];
    }

    public function session_cache($key, \Closure $closure)
    {
        $session_variable = 'cacheable_cache_'.$key;

        // return the cache if it exists
        if(!Session::has($session_variable))
        {
            Session::put($session_variable, $closure());
        }

        return Session::get($session_variable);
    }

    public function cache($key, \Closure $closure, $expires_minutes = 15)
    {
        $cache_variable = 'cacheable_cache_'.$key;

        // return the cache if it exists
        if(!Cache::has($cache_variable))
        {
            Cache::put($cache_variable, $closure(), $expires_minutes);
        }

        return Cache::get($cache_variable);
    }
}