'use strict';

var gulp         = require('gulp');
var config       = require('./_config');
var runSequence  = require('run-sequence');
var del          = require('del');

gulp.task('clean', del.bind(null, [config.project.dest]));

gulp.task('build', ['clean'], function(callback) {
  runSequence('styles', 'scripts', 'icons', ['fonts', 'images'], callback);
});