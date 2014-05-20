<?php namespace Lio\Articles\UseCases; 

use Mockery as m;
use Lio\Articles\Entities\Article;
use Lio\Articles\StubbedArticleRepository;

class DeleteArticleHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Articles\UseCases\DeleteArticleHandler', $this->getHandler());
    }

    public function test_can_delete_article()
    {
        $articleRepository = m::mock('Lio\Articles\Repositories\ArticleRepository');
        $articleRepository->shouldReceive('getBySlug')->andReturn(new Article);
        $articleRepository->shouldReceive('save');

        $handler = $this->getHandler($articleRepository);
        $request = new DeleteArticleRequest('beep boop');
        $response = $handler->handle($request);
        $this->assertInstanceOf('Lio\Articles\UseCases\DeleteArticleResponse', $response);
        $this->assertInstanceOf('Lio\Articles\Entities\Article', $response->article);

        // Do you think this is enough for a delete use case?
    }

    private function getHandler($articleRepository = null)
    {
        return new DeleteArticleHandler($articleRepository ?: new StubbedArticleRepository);
    }
} 
