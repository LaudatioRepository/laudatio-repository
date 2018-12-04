const { mix } = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack buil  d steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


/*
mix.webpackConfig({
    plugins: [
        new webpack.ProvidePlugin({
            $               : 'jquery',
            jQuery          : 'jquery',
            'window.jQuery' : 'jquery',
            Popper          : ['popper.js', 'default'],
            Alert           : 'exports-loader?Alert!bootstrap/js/dist/alert',
            Button          : 'exports-loader?Button!bootstrap/js/dist/button',
            Carousel        : 'exports-loader?Carousel!bootstrap/js/dist/carousel',
            Collapse        : 'exports-loader?Collapse!bootstrap/js/dist/collapse',
            Dropdown        : 'exports-loader?Dropdown!bootstrap/js/dist/dropdown',
            Modal           : 'exports-loader?Modal!bootstrap/js/dist/modal',
            Popover         : 'exports-loader?Popover!bootstrap/js/dist/popover',
            Scrollspy       : 'exports-loader?Scrollspy!bootstrap/js/dist/scrollspy',
            Tab             : 'exports-loader?Tab!bootstrap/js/dist/tab',
            Tooltip         : "exports-loader?Tooltip!bootstrap/js/dist/tooltip",
            Util            : 'exports-loader?Util!bootstrap/js/dist/util',
        }),
    ],
});
 */

mix.autoload({
    //'jquery': ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"],
    'popper.js/dist/umd/popper.js': ['Popper', 'window.Popper'],
    'nouislider/distribute/nouislider.js': ['noUiSlider', 'window.noUiSlider'],
    //'dropzone/dist/dropzone.js': ['Dropzone', 'window.Dropzone'],
});

mix.js('resources/assets/js/searchapp.js', 'public/js')
    .js('resources/assets/js/jq.js', 'public/js')
    .sass('resources/assets/sass/laudatio.scss','public/css')
    .sass('resources/assets/sass/nouislider.min.scss', 'public/css');

mix.js('resources/assets/js/browseapp.js', 'public/js')
    .sass('resources/assets/sass/browseapp.scss', 'public/css');
