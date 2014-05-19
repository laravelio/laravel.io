<?php namespace Lio\Accounts;

class MemberTest extends \UnitTestCase
{
    public function test_can_create_member()
    {
        $this->assertInstanceOf('Lio\Accounts\Member', new Member);
    }

    public function test_can_register_member()
    {
        $member = Member::register('name', 'email', 'githubUrl', 'githubId', 'imageUrl');

        $this->assertEquals([
            'name' => 'name',
            'email' => 'email',
            'github_url' => 'githubUrl',
            'github_id' => 'githubId',
            'image_url' => 'imageUrl',
        ], $member->getAttributes());

        $events = $member->releaseEvents();

        // will add this later
        $this->assertCount(0, $events);
    }

    public function test_member_can_be_banned()
    {
        $member = new Member;
        $member->bannedBy(new Member);
        $this->assertEquals(1, $member->is_banned);
    }
}
