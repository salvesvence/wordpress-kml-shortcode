var gulp = require('gulp'),
    cssmin = require('gulp-cssmin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify');

gulp.task('minify', function() {

    gulp.src('wp-content/resources/css/app.css')
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('wp-content/resources/css'));
});

gulp.task('uglify', function() {

    gulp.src(
        [
            'wp-content/resources/js/ZipFile.complete.js',
            'wp-content/resources/js/geoxml3.js',
            'wp-content/resources/js/app.js'
        ])
        .pipe(concat('app.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('wp-content/resources/js'));
});

gulp.task('default', ['minify', 'uglify'], function(){});