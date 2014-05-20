<?php namespace Lio\Forum\UseCases;

use App;
use Lio\Events\Dispatcher;
use Mockery as m;

class ListThreadsHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Forum\UseCases\ListThreadsHandler', $this->getHandler());
    }

    public function test_can_get_response()
    {
        $threadRepository = m::mock('Lio\Forum\ThreadRepository');
        $threadRepository->shouldReceive('getPageByTagsAndStatus')->andReturn('foo');

        $request = new ListThreadsRequest('tags', 'status', 0, 10);
        $response = $this->getHandler(null, $threadRepository)->handle($request);

        $this->assertInstanceOf('Lio\Forum\UseCases\ListThreadsResponse', $response);
        $this->assertEquals('foo', $response->threads);
    }

    private function getHandler($dispatcher = null, $threadRepository = null)
    {
        return new ListThreadsHandler(
            $dispatcher ?: new Dispatcher,
            $threadRepository ?: m::mock('Lio\Forum\ThreadRepository')
        );
    }
}
