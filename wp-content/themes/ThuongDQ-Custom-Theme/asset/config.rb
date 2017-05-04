var compass = require('gulp-compass'),
  path = require('path');
 
gulp.task('compass', function() {
  gulp.src('./scss/*.scss')
    .pipe(compass({
      project: path.join(__dirname, 'app'),
      css: 'css',
      sass: 'sass'
    }))
    .pipe(gulp.dest('app/css/'));
});