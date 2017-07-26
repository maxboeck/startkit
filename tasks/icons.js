'use strict';

var gulp         = require('gulp');
var config       = require('./_config');
var plugins      = require('gulp-load-plugins');
var browserSync  = require('browser-sync').create();
var $            = plugins();

var spriteConfig = {
  mode: {
    inline: true,
    symbol: {
      dest: 'icons',
      sprite: 'sprite.svg',
      example: false 
    }
  },
  shape: {
    id: {
      generator: 'icon-%s'
    }
  },
  svg: {
    xmlDeclaration: false, 
    doctypeDeclaration: false
  }
};

gulp.task('icons', function() {
  return gulp.src( config.globs.icons )
    .pipe($.plumber({
      errorHandler: function (err) {
        $.util.log($.util.colors.red(err));
        this.emit('end');
      }
    }))
    .pipe($.svgSprite(spriteConfig))
    .pipe(gulp.dest( config.project.dest ))
});