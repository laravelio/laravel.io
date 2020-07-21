<?php

if (! function_exists('active')) {
    /**
     * Sets the menu item class for an active route.
     */
    function active($routes, bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], (array) $routes) && $condition ? 'active' : '';
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
     */
    function route_to_reply_able($replyAble): string
    {
        if ($replyAble instanceof App\Models\Thread) {
            return route('thread', $replyAble->slug());
        }
    }
}

if (! function_exists('linkyfy')) {
    /**
     * Convert Standalone Urls to HTML.
     */
    function linkyfy(string $markdown): string
    {
        $lf=new LinkFinder([
                "attrs" => ["class" => "external-link", "target" => "_blank", "rel" => "nofollow"],
                "mailto_attrs" => ["class" => "external-email"]
                ]);
        return $lf->processHtml($markdown);
    }
}
