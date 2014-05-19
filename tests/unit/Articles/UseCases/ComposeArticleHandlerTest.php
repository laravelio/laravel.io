<?php namespace Lio\Articles\UseCases;

use App;

class ComposeArticleHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Articles\UseCases\ComposeArticleHandler', $this->getHandler());
    }

    private function getHandler($articleRepository = null, $dispatcher = null)
    {
        return new ComposeArticleHandler(
            $articleRepository ?: App::make('Lio\Articles\ArticleRepository'),
            $dispatcher ?: App::make('Lio\Events\Dispatcher')
        );
    }
} 
