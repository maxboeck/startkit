'use strict';

var gulp         = require('gulp');
var config       = require('./_config');
var plugins      = require('gulp-load-plugins');
var importer     = require('node-sass-tilde-importer');
var browserSync  = require('browser-sync').create();
var $            = plugins();


gulp.task('styles', function() {
  return gulp.src( config.main.css )
    .pipe($.plumber({
      errorHandler: function(err) {
        $.util.log($.util.colors.red(err));
        this.emit('end');
      },
    }))
    .pipe( $.sourcemaps.init() )
    .pipe( $.sass( {
      outputStyle: 'nested',
      precision: 10,
      importer: importer
    } ) )
    .pipe( $.autoprefixer() )
    .pipe( $.cssnano( { safe: true } ))
    .pipe( $.rename( { suffix: '.min' } ))
    .pipe( $.sourcemaps.write('.') )
    .pipe( gulp.dest( config.project.dest + '/styles' ) )
    .pipe( browserSync.stream() );
 });