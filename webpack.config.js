const path = require('path');
//const HardSourceWebpackPlugin = require('hard-source-webpack-plugin');
//const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

module.exports = {
    mode: "development",
    // plugins: [
    //     new HardSourceWebpackPlugin(),
    //     new BundleAnalyzerPlugin({
    //          analyzerHost : "0.0.0.0"
    //      })
    // ],
    entry: {
        client : ['./src/index.tsx']
    },
    //   devtool: 'inline-source-map',
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: [
                    {
                        loader: 'ts-loader',
                        options: {
                            transpileOnly: true,
                            experimentalWatchApi: true,
                        },
                    },
                ],
                exclude: /node_modules/
            },
            {
                test: /\.(css|scss)$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /\.(png|svg|jpg|gif)$/,
                use: [
                    'file-loader'
                ]
            },
            {
                test: /\.(woff|woff2)$/,
                use: [{
                    loader: 'file-loader',
                    options :{
                        name : 'fonts/[name].[ext]',
                        mimetype: 'application/font-woff',
                        publicPath: '../'
                    }
                }],

            }
        ]
    },
    resolve: {
        extensions: [ '.tsx', '.ts', '.js' ]
    },
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'dist')
    },
    watchOptions: {
        poll: true
    }

};
