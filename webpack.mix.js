/**
 * @date 12-24-2020
 * @author Greg
 * TODO: Having problem with URL Processing
 * Help may be here: https://github.com/postcss/postcss-url
 * I think there may be better ways to handle the image URLs via Tailwinds and SCSS approach
 * Because this test is an existing theme with preexisting file paths for code we are not even using
 *   I dealt with the background images in elements.css .. Hopefully in a site built with SCSS,
 *   URL processing will be effective
 */

let mix = require('laravel-mix');
require('laravel-mix-postcss-config');
let { CleanWebpackPlugin } = require("clean-webpack-plugin");

mix
//    .js('layout/js/app.js', 'dist/js/app.js')
    .options({
        processCssUrls: false
    })
    .css('style.css', 'dist/css/style.css')
    .postCss('layout/css/app.css', 'dist/css/app.css', [
        require('postcss-custom-properties'),
        require('postcss-sorting')({
            'properties-order': 'alphabetical'
        }),
        require('postcss-url')({
         // Seeking options that work with Mix
        }),
        require('cssnano')
    ])
    .copyDirectory( 'images', 'dist/images' )
    .browserSync({proxy: 'http://localhost:10018/'})
    .webpackConfig({
        plugins: [
            new CleanWebpackPlugin({
                // Simulate the removal of files
                // default: false
                dry: false,

                // Write Logs to Console
                // (Always enabled when dry is true)
                // default: false
                verbose: false,

                // Automatically remove all unused webpack assets on rebuild
                // default: true
                cleanStaleWebpackAssets: true,

                // Do not allow removal of current webpack assets
                // default: true
                protectWebpackAssets: true,
                cleanOnceBeforeBuildPatterns: ['dist/*', '!static-files*'],
            })
            ]
         }
    );
