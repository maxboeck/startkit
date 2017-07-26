'use strict';

var gulp            = require('gulp');
var config          = require('./_config');
var plugins         = require('gulp-load-plugins');
var webpack         = require('webpack');
var webpackStream   = require('webpack-stream');
var named           = require('vinyl-named');
var $               = plugins();

var webpackConfig = {
  module: {
    loaders: [{
      test: /\.js$/,
      exclude: '/node_modules/',
      loader: 'babel-loader',
      query: {
        presets: ['env']
      }
    }],
  },
  output: {
    filename: "[name].min.js"
  },
  plugins: [
    new webpack.ProvidePlugin({
      '$': 'jquery', 
      'jQuery': 'jquery'
    }),
    new webpack.optimize.UglifyJsPlugin()
  ],
  externals: {
    jquery: 'window.jQuery'
  },
  devtool: 'source-map'
};

gulp.task( 'scripts', function() {
  return gulp.src( config.main.js )
    .pipe($.plumber({
      errorHandler: function(err) {
        $.util.log($.util.colors.red(err));
        this.emit('end');
      }
    }))
    .pipe(named())
    .pipe(webpackStream(webpackConfig))
    .pipe(gulp.dest(config.project.dest + '/scripts'));
});