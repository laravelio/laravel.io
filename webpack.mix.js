const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sourceMaps(true, 'hidden-source-map')
    .postCss('resources/css/app.css', 'public/css', [require('tailwindcss')])
    .version();

mix.disableSuccessNotifications();
