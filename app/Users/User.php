<?php
namespace Lio\Users;

interface User
{
    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function githubUsername();
}
