<?php

use Illuminate\Support\Facades\Blade;

Blade::directive('error', function ($expression) {
    return "<?php echo \$errors->first($expression, '<span class=\"block text-sm text-red-500 mt-2\">:message</span>'); ?>";
});

Blade::directive('title', function ($expression) {
    return "<?php \$title = $expression ?>";
});

Blade::directive('shareImage', function ($expression) {
    return "<?php \$shareImage = $expression ?>";
});

Blade::directive('canonical', function ($expression) {
    return "<?php \$canonical = $expression ?>";
});
