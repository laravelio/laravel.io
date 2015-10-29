<?php
namespace Lio\Users;

interface UserRepository
{
    /**
     * @param string $username
     * @return \Lio\Users\User
     */
    public function findByUsername($username);
}
