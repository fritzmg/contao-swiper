var gulp = require('gulp');
var runSequence = require('run-sequence');
var plumber = require('gulp-plumber');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');

gulp.task('compressJS', function(){
  return gulp.src(['src/Resources/public/contao-swiper.js'])
             .pipe(plumber())
             .pipe(rename({ suffix: '.min' }))
             .pipe(uglify())
             .pipe(gulp.dest('src/Resources/public/'));
});

// Watchers
gulp.task('watch', function(callback) {
  runSequence([
      'compressJS'
    ], [
      'watch:js',
    ],
    callback
  );
});

gulp.task('watch:js', function() {
  gulp.watch('src/Resources/public/contao-swiper.js', ['compressJS']);
});

gulp.task('default', function(callback) {
  runSequence(['watch'],
    callback
  );
});

gulp.task('build', function(callback) {
  runSequence([
      'compressJS'
    ],
    callback
  );
});
