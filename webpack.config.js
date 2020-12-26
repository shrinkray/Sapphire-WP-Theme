module.exports = {
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
};
module.exports = webpackConfig;