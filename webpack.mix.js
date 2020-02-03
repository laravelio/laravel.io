const mix = require('laravel-mix');
const FlareWebpackPluginSourcemap = require("@flareapp/flare-webpack-plugin-sourcemap");

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

mix.js('resources/js/app.js', 'public/js')
    .webpackConfig({
        plugins: [new FlareWebpackPluginSourcemap({ key: process.env.FLARE_KEY })],
    })
    .sourceMaps(true, 'hidden-source-map')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .version();
