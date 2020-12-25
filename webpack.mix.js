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

// Commented out assignments are from the postcss-url plugin page example
// const fs = require("fs")
// const postcss = require("postcss")
// const url = require("postcss-url")
//
// // css to be processed
// const css = fs.readFileSync("layout/css/app.css", "utf8")

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
    .browserSync({proxy: 'http://localhost:10018/'});
