const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const webpack = require('webpack');
const WebpackBar = require('webpackbar');

module.exports = {
    entry: './src/app.js',
    output: {
        filename: 'main.bundle.js',
        path: path.resolve(__dirname, 'dist')
    },

    stats: {},

    externals: {
        jquery: 'jQuery'
    },

    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()],
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: 'main.style.css',
            chunkFilename: '[id].css',
            ignoreOrder: false, // Enable to remove warnings about conflicting order
        }),
        new OptimizeCssAssetsPlugin({
            assetNameRegExp: /\.css$/g,
            cssProcessor: require('cssnano'),
            cssProcessorPluginOptions: {
                preset: ['default', { discardComments: { removeAll: true } }],
            },
            canPrint: true
        }),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            Popper: 'popper.js'
        }),
        new CopyPlugin([{
            from: 'src/img/',
            to: 'img',
            from: 'src/fonts/',
            to: 'fonts'
        }]),
        new ImageminPlugin({
            test: /\.(jpe?g|png|gif|svg)$/i
        }),
        new WebpackBar({
            profile: true,
            basic: false
        }),
        new BrowserSyncPlugin({
            files: ['*.css', '*.js', '*.php'],
            host: 'localhost',
            port: 3000,
            proxy: 'http://wordpress.local/'
        }),
    ],

    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use: [
                    'babel-loader'
                ],
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            minimize: true
                        },
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            url: false
                        }
                    },
                    'sass-loader',
                ],
            }
        ]
    }
};
