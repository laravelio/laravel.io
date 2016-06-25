<?php

use League\CommonMark\CommonMarkConverter;

/** @todo Don't implicitly bind CommonMarkConverter class */
Blade::directive('md', function($expression) {
    return "<?php echo (new " . CommonMarkConverter::class . "())->convertToHtml($expression); ?>";
});
