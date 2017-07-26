'use strict';

var gulp         = require('gulp');
var imagemin     = require('gulp-imagemin');
var config       = require('./_config');
var browserSync  = require('browser-sync').create();

gulp.task('images', function() {
  return gulp.src( config.globs.images )
    .pipe(imagemin([
      imagemin.jpegtran({progressive: true}),
      imagemin.gifsicle({interlaced: true}),
      imagemin.svgo({plugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}]})
    ]))
    .pipe(gulp.dest( config.project.dest + '/images' ))
});