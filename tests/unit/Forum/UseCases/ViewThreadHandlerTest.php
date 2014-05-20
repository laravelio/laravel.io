<?php namespace Lio\Forum\UseCases;

use App;
use Lio\Events\Dispatcher;
use Lio\Forum\Threads\Thread;
use Mockery as m;

class ViewThreadHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Forum\UseCases\ViewThreadHandler', $this->getHandler());
    }

    public function test_can_get_response()
    {
        $thread = new Thread;
        $thread->id = 666;

        $threadRepository = m::mock('Lio\Forum\ThreadRepository');
        $threadRepository->shouldReceive('getBySlug')->andReturn($thread);

        $replyRepository = m::mock('Lio\Forum\ReplyRepository');
        $replyRepository->shouldReceive('getRepliesForThread')->andReturn('bar');

        $request = new ViewThreadRequest('slug', 'page', 12);
        $response = $this->getHandler(null, $threadRepository, $replyRepository)->handle($request);

        $this->assertInstanceOf('Lio\Forum\UseCases\ViewThreadResponse', $response);
        $this->assertEquals(666, $response->thread->id);
        $this->assertEquals('bar', $response->replies);
    }

    private function getHandler($dispatcher = null, $threadRepository = null, $replyRepository = null)
    {
        return new ViewThreadHandler(
            $dispatcher ?: new Dispatcher,
            $threadRepository ?: m::mock('Lio\Forum\ThreadRepository'),
            $replyRepository ?: m::mock('Lio\Forum\ReplyRepository')
        );
    }

}
