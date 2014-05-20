<?php namespace unit\Articles\UseCases; 

use Mockery as m;
use Lio\Articles\Entities\Article;
use Lio\Articles\StubbedArticleRepository;
use Lio\Articles\UseCases\EditArticleHandler;
use Lio\Articles\UseCases\EditArticleRequest;

class EditArticleHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Articles\UseCases\EditArticleHandler', $this->getHandler());
    }

    public function test_can_edit_article()
    {
        $articleRepository = m::mock('Lio\Articles\Repositories\ArticleRepository');
        $articleRepository->shouldReceive('getBySlug')->andReturn(new Article);
        $articleRepository->shouldReceive('save');

        $handler = $this->getHandler($articleRepository);
        $request = new EditArticleRequest('slug', 'new title', 'new content');
        $response = $handler->handle($request);

        $this->assertInstanceOf('Lio\Articles\UseCases\EditArticleResponse', $response);
        $this->assertInstanceOf('Lio\Articles\Entities\Article', $response->article);
        $this->assertEquals('new title', $response->article->title);
        $this->assertEquals('new content', $response->article->content);
    }

    private function getHandler($articleRepository = null)
    {
        return new EditArticleHandler($articleRepository ?: new StubbedArticleRepository);
    }
}
