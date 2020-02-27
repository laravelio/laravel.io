const mix = require('laravel-mix');
const FlareWebpackPluginSourcemap = require("@flareapp/flare-webpack-plugin-sourcemap");

mix.js('resources/js/app.js', 'public/js')
    .webpackConfig({
        plugins: [
            new FlareWebpackPluginSourcemap({ key: process.env.MIX_FLARE_KEY })
        ],
    })
    .sourceMaps(true, 'hidden-source-map')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .version();
