module.exports = {

    preset: [require('cssnano-preset-default'), {discardComments: false}],

    plugins: [
        'autoprefixer', { remove: false }
    ]
}