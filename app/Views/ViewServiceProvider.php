<?php

namespace Lio\Views;

use Blade;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /** @todo Don't implicitly bind CommonMarkConverter class */
        Blade::directive('md', function($expression) {
            return "<?php echo (new " . CommonMarkConverter::class . "())->convertToHtml($expression); ?>";
        });
    }

    public function register()
    {
    }
}
