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

mix.autoload({
    'jquery': ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"],
    'popper.js/dist/umd/popper.js': ['Popper', 'window.Popper'],
    'dropzone/dist/dropzone.js': ['Dropzone', 'window.Dropzone']
});

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.js('node_modules/cropperjs/src/js/cropper.js', 'public/js');
mix.copy('node_modules/cropperjs/src/css/cropper.css', 'public/css/cropper.css');

mix.js('resources/assets/js/adminFileUpload.js', 'public/js')
    .sass('resources/assets/sass/adminFileUpload.scss', 'public/css');

mix.js('resources/assets/js/browseapp.js', 'public/js')
    .sass('resources/assets/sass/browseapp.scss', 'public/css');

mix.js('resources/assets/js/sb-admin.js', 'public/js')
    .sass('resources/assets/sass/sb-admin.scss', 'public/css');

mix.js('resources/assets/js/metisMenu.js', 'public/js')
    .sass('resources/assets/sass/admin.scss', 'public/css');
