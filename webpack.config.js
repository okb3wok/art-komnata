const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const isProduction = process.env.NODE_ENV == 'production';
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
let environment = process.env.NODE_ENV || 'development';
const CopyWebpackPlugin = require('copy-webpack-plugin');
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

let stylesHandler = 'style-loader';

if (environment!='development') {
  console.log('[PRODUCTION]');
  stylesHandler = MiniCssExtractPlugin.loader;
}

const config = {
  entry: './src/index.js',
  output: {
    clean: true,
    path: path.resolve(__dirname, 'dist'),
    filename: 'art.js',
    environment: {
      // The environment supports arrow functions ('() => { ... }').
      arrowFunction: true
    }

  },
  devServer: {
    static: './src',
    open: true,
    port: 9000,
    host: 'localhost',
    hot:true
  },
  plugins: [
    new HtmlWebpackPlugin({
      template: './src/templates/art.twig',
      filename: 'index.html',
      inject: false, // inject: 'body',
    }),
    new MiniCssExtractPlugin({
      filename: 'art.css'
    }),
    new CopyWebpackPlugin({
      patterns: [
        {
          from: path.resolve(__dirname, 'src/static'),
          to: path.resolve(__dirname, 'dist/static')
        },
      ],
    }),
  ],
  module: {
    rules: [
      {
        test: /\.twig$/,
        use: [
          { loader: 'twig-loader' }
        ]

      },
      {
        test: /\.s[ac]ss|css$/i,
        use: [stylesHandler, 'css-loader', 'postcss-loader', 'sass-loader'],
      },
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        type: 'asset/resource',
        generator: {
          filename: 'static/[name][ext]'
        }
      }
    ],
  },
  // externals: {
  //   ymaps3: 'ymaps3'
  // },
  devtool:false,
  optimization: {
    minimize: true,
    minimizer: [new TerserPlugin({
      extractComments: false,
      terserOptions: { output: {comments: false}}
    }), new CssMinimizerPlugin({
      minimizerOptions: {
        preset: [
          "default",
          {
            discardComments: { removeAll: true },
          },
        ],
      },
    })
    ],
  },

};

module.exports = () => {
  if (isProduction) {
    config.mode = 'production';
  } else {
    config.mode = 'development';
  }
  return config;
};
