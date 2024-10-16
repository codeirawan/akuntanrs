const mix = require('laravel-mix');

// Combine all CSS styles into a single file
mix.styles([
    'public/css/custom.css',
    'public/css/auth.css',
    'public/css/404.css',
    'public/css/datatable.css',
    'public/css/form/wizard.css'
], 'public/css/app.css');

// Combine all JavaScript files
mix.js('public/js/auth.js', 'public/js/app.js')
   .js('public/js/form/validation.js', 'public/js/app.js')
   .js('public/js/datatable.js', 'public/js/app.js')
   .js('public/js/tooltip.js', 'public/js/app.js')
   .js('public/js/form/thousand-separator.js', 'public/js/app.js')
   .js('resources/js/app.js', 'public/js/app.js');

// Versioning the files for cache busting
mix.version();
