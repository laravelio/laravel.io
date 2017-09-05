const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/build/js')
    .sass('resources/assets/sass/app.scss', 'public/build/css')
    .version()
    .copy('node_modules/markdown/lib/markdown.js', 'public/build/custom/markdown.js')
    .copy('node_modules/socket.io-client/dist/socket.io.js','public/js');
