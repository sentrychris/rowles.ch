const path = require('path')
const webpack = require('webpack')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const TerserPlugin = require('terser-webpack-plugin')

module.exports = {
    mode: 'production',
    entry: [
        './resources/assets/js/index.js',
        './resources/assets/scss/app.scss'
    ],
    output: {
        filename: 'js/rowles.bundle.js',
        path: path.resolve(__dirname, 'public'),
    },
    optimization: {
        minimizer: [new TerserPlugin({
            extractComments: false,
        })],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/rowles.bundle.css',
            chunkFilename: 'css/[id].css'
        }),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            Popper: ['popper.js', 'default']
        })
    ],
    module:  {
        rules: [
            {
                test: /\.s?css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: []
            },
        ],
    }
}