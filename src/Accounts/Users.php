<?php namespace Lio\Accounts; 

use Lio\Core\EventGenerator;

class Users
{
    use EventGenerator;

    public function addUser($email, $name, $githubUrl, $githubId, $imageUrl)
    {
        $user = new User([
            'email' => $email,
            'name' => $name,
            'github_url' => $githubUrl,
            'github_id' => $githubId,
            'image_url' => $imageUrl,
        ]);

        return $user;
    }

    public function banUser(User $problem, User $admin)
    {
        $problem->ban();
        
        return $problem;
    }
} 
