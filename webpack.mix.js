const mix = require('laravel-mix');

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

// Define your CSS and JS files here
mix.styles(['public/css/custom.css'], 'public/css/app.css')
   .js('resources/js/app.js', 'public/js/leaflet-geosearch.js')
   .version();
