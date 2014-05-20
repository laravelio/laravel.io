<?php namespace Lio\Articles\UseCases; 

use Lio\Accounts\Member;

class CommentOnArticleRequest
{
    public $articleId;
    /**
     * @var \Lio\Accounts\Member
     */
    public $author;
    public $content;

    public function __construct($articleId, Member $author, $content)
    {
        $this->articleId = $articleId;
        $this->author = $author;
        $this->content = $content;
    }
} 
