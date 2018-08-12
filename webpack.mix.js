let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
 /*
mix.styles([
    'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/styles.css',
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/font-awesome.css',
],'public/css/libs.css');

mix.styles([
    'resources/assets/css/metisMenu.css',
    'resources/assets/css/sb-admin-2.css',
],'public/css/libs2.css');*/