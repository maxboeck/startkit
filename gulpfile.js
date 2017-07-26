// Main Gulp File
'use strict';

var fs           = require('fs');
var gulp         = require('gulp');
var tasks        = fs.readdirSync('./tasks/');

tasks.forEach(function(task){
  if (task !== '_config.js') {
    require('./tasks/' + task);
  }
});

gulp.task('default', ['watch']);