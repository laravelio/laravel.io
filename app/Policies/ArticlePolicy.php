<?php

namespace App\Policies;

use App\Models\Article;
use App\User;

final class ArticlePolicy
{
    const UPDATE = 'update';
    const DELETE = 'delete';

    public function update(User $user, Article $article): bool
    {
        return $article->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }

    public function delete(User $user, Article $article): bool
    {
        return $article->isAuthoredBy($user) || $user->isModerator() || $user->isAdmin();
    }
}
