<?php
namespace Lio\Users;

interface UserRepository
{
    /**
     * @param string $username
     * @return \Lio\Users\User
     */
    public function findByUsername($username);

    /**
     * @param string $emailAddress
     * @return \Lio\Users\User|null
     */
    public function findByEmailAddress($emailAddress);

    /**
     * @param string $name
     * @param string $emailAddress
     * @param string $password
     * @param string $username
     * @param array $attributes
     * @return \Lio\Users\User
     */
    public function create($name, $emailAddress, $password, $username, array $attributes = []);
}
