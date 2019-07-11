var gulp = require('gulp');
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

gulp.task('watch', gulp.series(['compressJS'], function() {
  gulp.watch('src/Resources/public/contao-swiper.js').on('change', gulp.series(['compressJS']));
}));

gulp.task('build', gulp.series(['compressJS']));

gulp.task('default', gulp.series(['build']));
