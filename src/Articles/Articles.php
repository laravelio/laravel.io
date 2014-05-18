<?php namespace Lio\Articles;use Lio\Accounts\Member;

/**
 * Class Articles
 * Root
 * @package Lio\Articles
 */
class Articles
{
    public function addArticle(Member $author, $title, $content, $status, $laravelVersion, array $tagIds = [])
    {
        $article = new Article([
            'author_id' => $author->id,
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'laravel_version' => $laravelVersion,
        ]);

        $article->setTagsById($tagIds);

        return $article;
    }
} 
