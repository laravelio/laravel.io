<?php namespace Lio\Github\Requests;

abstract class CurlRequest
{
    private $handle;

    protected function init($url)
    {
        $this->handle = curl_init($url);
    }

    protected function setOption($name, $value) {
        curl_setopt($this->handle, $name, $value);
    }

    protected function execute() {
        return curl_exec($this->handle);
    }

    protected function getInfo($name) {
        return curl_getinfo($this->handle, $name);
    }

    protected function close() {
        curl_close($this->handle);
    }

    protected function jsonResponse($string)
    {
        return (array) json_decode($string);
    }
} 
