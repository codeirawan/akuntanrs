const mix = require('laravel-mix');

/*
 |---------------------------------------------------------------------
 | Mix Asset Management
 |---------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Copy CSS files
mix.copy('public/css/404.css', 'public/mix/css/404.css')
   .copy('public/css/app.css', 'public/mix/css/app.css')
   .copy('public/css/auth.css', 'public/mix/css/auth.css')
   .copy('public/css/custom.css', 'public/mix/css/custom.css')
   .copy('public/css/datatable.css', 'public/mix/css/datatable.css')
   .copy('public/css/journal.css', 'public/mix/css/journal.css')
   .copy('public/css/form/wizard.css', 'public/mix/css/form/wizard.css')

// Copy fonts directory
   .copyDirectory('public/css/fonts', 'public/mix/css/fonts')

// Copy JS files
   .copy('public/js/app.js', 'public/mix/js/app.js')
   .copy('public/js/auth.js', 'public/mix/js/auth.js')
   .copy('public/js/datatable.js', 'public/mix/js/datatable.js')
   .copy('public/js/form/thousand-separator.js', 'public/mix/js/form/thousand-separator.js')
   .copy('public/js/form/validation.js', 'public/mix/js/form/validation.js')
   .copy('public/js/tooltip.js', 'public/mix/js/tooltip.js');

// No need for .version() if you're just copying files
