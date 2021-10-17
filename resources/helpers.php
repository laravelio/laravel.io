<?php

if (! function_exists('active')) {
    /**
     * Sets the menu item class for an active route.
     *
     * @param mixed $routes
     */
    function active($routes, bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], (array) $routes) && $condition ? 'active' : '';
    }
}

if (! function_exists('is_active')) {
    /**
     * Determines if the given routes are active.
     *
     * @param mixed $routes
     */
    function is_active($routes): bool
    {
        return (bool) call_user_func_array([app('router'), 'is'], (array) $routes);
    }
}

if (! function_exists('md_to_html')) {
    /**
     * Convert Markdown to HTML.
     */
    function md_to_html(string $markdown): string
    {
        return app(App\Markdown\Converter::class)->toHtml($markdown);
    }
}

if (! function_exists('route_to_reply_able')) {
    /**
     * Returns the route for the replyAble.
     *
     * @param mixed $replyAble
     */
    function route_to_reply_able($replyAble): string
    {
        if ($replyAble instanceof App\Models\Thread) {
            return route('thread', $replyAble->slug());
        }
    }
}

if (! function_exists('replace_links')) {
    /**
     * Convert Standalone Urls to HTML.
     */
    function replace_links(string $markdown): string
    {
        return (new LinkFinder([
            'attrs' => ['target' => '_blank', 'rel' => 'nofollow'],
        ]))->processHtml($markdown);
    }
}

if (! function_exists('canonical_route')) {
    /**
     * Generate a canonical URL to the given route and allowed list of query params.
     */
    function canonical_route(string $route, array $params = []): string
    {
        $page = app('request')->get('page');
        $params = array_merge($params, ['page' => $page != 1 ? $page : null]);
        ksort($params);

        return route($route, $params);
    }
}
