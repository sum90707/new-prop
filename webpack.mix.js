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
   .js('resources/assets/js/main.js', 'public/js')
   .js('resources/assets/js/alertmsg.js', 'public/js')
   .js('resources/assets/js/process-form.js', 'public/js')
   .js('resources/assets/js/copied.js', 'public/js')
   .js('resources/assets/js/toggle.js', 'public/js')
   .js('resources/assets/js/upload.js', 'public/js')
   .js('resources/assets/js/dynamic.js', 'public/js')
   .js('resources/assets/js/home.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
