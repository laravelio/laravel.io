<?php  namespace Lio\Notifications\Tasks;

use Lio\Accounts\Member;
use Lio\Notifications\ForumTag;
use Lio\Notifications\UserTagParser;

class SearchNewForumPostForForumUserTags
{
    private $post;
    private $parser;

    public function __construct($post)
    {
        $this->post = $post;
        $this->parser = new UserTagParser;
    }

    public function run()
    {
        $usernames = $this->parser->parseForUsers($this->post->body);

        if (count($usernames) > 5) {
            return;
        }

        foreach ($usernames as $username) {
            $this->createUserTagNotification($username, $this->post);
        }
    }

    private function createUserTagNotification($username, $post)
    {
        $user = $this->getUser($username);
        if ($user) {
            $this->insertNotificationRecord($user, $post);
        }
    }

    private function getUser($username)
    {
        return Member::where('name', '=', $username)->where('is_banned', '=', 0)->first();
    }

    private function insertNotificationRecord(Member $user, $post)
    {
        $notification = new ForumTag;
        $notification->user_id = $user->id;
        $notification->setSubject($post);
        $notification->save();
    }
} 
