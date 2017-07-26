'use strict';

var gulp         = require('gulp');
var imagemin     = require('gulp-imagemin');
var config       = require('./_config');
var browserSync  = require('browser-sync').create();
var reload       = browserSync.reload;

gulp.task('watch', ['build'], function() {
  browserSync.init( {
    files: [ config.project.dest + '/styles/*.css' ],
    proxy: config.project.devURL,
    open:true,
    injectChanges: true
  });

  gulp.watch(config.globs.php, reload);
  gulp.watch(config.globs.styles, ['styles']);
  gulp.watch(config.globs.scripts, ['scripts', reload]);
  gulp.watch(config.globs.fonts, ['fonts', reload]);
  gulp.watch(config.globs.images, ['images', reload]);
  gulp.watch(config.globs.icons, ['icons', reload]);
});