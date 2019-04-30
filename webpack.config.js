const path = require('path');
const webpack = require('webpack'); // reference to webpack Object
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

const extractSass = new ExtractTextPlugin({
    filename: "style.min.css",
});

const paths = {
    DIST: path.resolve(__dirname, 'dist'),
    SRC: path.resolve(__dirname, 'src')
};

const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

module.exports = {
    entry: [
        path.join(paths.SRC, 'index.js')
    ],

    output: {
        path: paths.DIST,
        filename: 'main.bundle.js'
    },

	externals: {
	  jquery: 'jQuery'
	},

    plugins: [
        new BrowserSyncPlugin({
            files: ['*.css', '*.js', '*.php'],
            host: 'localhost',
            port: 3000,
            proxy: 'http://wordpress.local/'
        }),
        new webpack.ProvidePlugin({
          $: 'jquery',
          jQuery: 'jquery',
          Popper: 'popper.js'
        }),
        new UglifyJSPlugin(),
        extractSass
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
            	test: /\.scss$/,
            	use: extractSass.extract({
            		use: [{
            			loader: "css-loader"
            		}, {
            			loader: "sass-loader"
            		}],
					// use style-loader in development
					fallback: "style-loader"
				})
            }, 
            {
            	test: /\.css$/,
            	loader: 'style-loader',
            },
            {
            	test: /\.css$/,
            	loader: 'css-loader',
            	options: {
            		minimize: true
            	}
            }
        ],
    },

    resolve: {
        extensions: ['.js', '.jsx'],
    },
};
