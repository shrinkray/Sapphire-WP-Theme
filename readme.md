# Sapphire WP Legacy Theme
_A legacy theme that gets a new life. This theme packaged with WP Bakery Visual Composer and a few other plugins._

## Description

In 2013 this was a modern design with clean lines and styling for a wide variety of content. Exactly how a business design should be. 

## Features:
* powerful theme options panel
* visual composer, revolution slider and contact form 7 integration
* translation ready 

## Install Laravel Mix Webpack
[Laravel Mix Installation Docs](https://laravel-mix.com/docs/6.0/installation)

``` 
$ npm init -y

```
Depending on what you need, install all or some of these packages running the install script (below) the packages listed in package.json will lead installation of all the dependencies. 

`$ npm install`

### A list of the Dev Dependencies you can add instead
```
$ npm install laravel-mix --save-dev

browser-sync browser-sync-webpack-plugin cross-env cssnano cssnano-preset-advanced cssnano-preset-default laravel-mix-postcss-config postcss postcss-cli postcss-custom-properties postcss-preset-env postcss-sorting postcss-url purify-css resolve-url-loader
```
## Running Mix
```
$ npm run dev
$ npm run watch
```
## Replace Scripts
```
"scripts": {
    "dev": "npm run development",
    "development": "npx mix",
    "watch": "npx mix watch",
    "prod": "npm run production",
    "production": "npx mix -p"
  },
  ```
### Changelog 
* 1.2 -- Add Laravel Mix, PostCSS, and BrowserSync
* 1.0 -- Initial release
