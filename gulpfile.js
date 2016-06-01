var gulp = require('gulp'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify');

gulp.task('uglify', function() {

    gulp.src(
        [
            'resources/js/ZipFile.complete.js',
            'resources/js/geoxml3.js',
            'resources/js/app.js'
        ])
        .pipe(concat('app.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('resources/js'));
});

gulp.task('default', ['uglify'], function(){});