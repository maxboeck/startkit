'use strict';

var gulp         = require('gulp');
var plugins      = require('gulp-load-plugins');
var config       = require('./_config');
var pkg          = require('../package.json');
var browserSync  = require('browser-sync').create();
var $ = plugins();

gulp.task('translate', function() {
  return gulp.src( config.globs.php )
    .pipe($.sort())
    .pipe($.wpPot({
      domain        : config.i18n.textDomain,
      destFile      : pkg.name + '.pot',
      package       : pkg.name,
      lastTranslator: pkg.author,
    }))
    .pipe(gulp.dest(config.i18n.dest))
});