var gulp = require('gulp'),
	livereload = require('gulp-livereload'),
	gulpIf = require('gulp-if'),
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	sourcemaps = require('gulp-sourcemaps');

gulp.task('sass', done => {
  gulp.src('sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(autoprefixer('last 2 version'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('css'));
    done();
});

gulp.task('watch', done => {
    livereload.listen();

    gulp.watch('sass/**/*.scss', gulp.series('sass'));
    gulp.watch(['css/style.css'], function (files){
        livereload.changed(files)
    });
    done();
});
