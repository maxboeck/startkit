'use strict';

var gulp         = require('gulp');
var flatten      = require('gulp-flatten');
var config       = require('./_config');
var browserSync  = require('browser-sync').create();

var fontsDestination = config.project.dest + '/fonts';

gulp.task('fonts', function() {
  return gulp.src( config.globs.fonts )
    .pipe(flatten())
    .pipe(gulp.dest(fontsDestination))
    .pipe(browserSync.stream());
});