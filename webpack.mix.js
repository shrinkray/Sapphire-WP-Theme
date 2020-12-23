let mix = require('laravel-mix');
//require('laravel-mix-postcss-config');

mix
    //  .js('layout/js/app.js', 'dist/')
    .js('layout/js/app.js', 'dist/app.js')
    .postCss('layout/css/layout.css', 'dist/app.css', [
        require('postcss-custom-properties'),
        require('postcss-sorting')({
            'properties-order': 'alphabetical'
        }),
        require('cssnano')
    ])
    .browserSync({proxy: 'http://localhost:10018/'});
