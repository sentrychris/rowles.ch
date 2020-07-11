const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    mode: 'production',
    entry: [
        './resources/assets/js/main.js',
        './resources/assets/scss/app.scss'
    ],
    output: {
        filename: 'js/main.js',
        path: path.resolve(__dirname, 'public'),
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "css/[name].css",
            chunkFilename: "css/[id].css"
        }),
    ],
    module:  {
        rules: [
            {
                test: /\.s?css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "sass-loader"
                ]
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: []
            },
        ],
    }
};