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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')

   .sass('resources/sass/auth/login.scss', 'public/css/auth')
   .sass('resources/sass/auth/dashboard.scss', 'public/css/auth')
   .sass('resources/sass/auth/enquiry.scss', 'public/css/auth');

