const path = require('path');

module.exports = {
    mode: 'development',
    devtool: 'inline-source-map',
    devServer: {
        contentBase: path.join(__dirname, 'public'),
        compress: true,
        port: 9000
    },
    entry: './resources/assets/js/main.js',
    output: {
        filename: 'app.js',
        path: path.resolve(__dirname, 'public/js'),
    },
    module:  {
        rules: [
            {
                test: /\.(scss)$/,
                use: [{
                    // injects CSS into the page.
                    loader: 'style-loader',
                }, {
                    // Translates CSS into CommonJS modules.
                    loader: 'css-loader',
                }, {
                    // Compiles Sass to CSS.
                    loader: 'sass-loader'
                }]
            },
        ],
    }
};