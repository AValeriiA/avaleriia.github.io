var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

// var sassPaths = [
//   'node_modules/foundation-sites/scss',
//   'bower_components/motion-ui/src'
// ];

var jsSources = ['js/**/*.js'],
    sassSources = ['public/assets/scss/**/*.scss'],
    htmlSources = ['public/*.html'];

gulp.task('sass', function () {
    return gulp.src(sassSources)
        .pipe($.sass({
            // includePaths: sassPaths,
            outputStyle: 'compressed'
        })
            .on('error', $.sass.logError))
        .pipe($.autoprefixer({
            browers: ['last 2 versions', 'ie >= 9']
        }))
        .pipe(gulp.dest('public/assets/css'))
        // .pipe($.livereload());
});

gulp.task('reload', function () {
    return gulp.src(htmlSources)
        // .pipe($.livereload());
});

gulp.task('default', ['sass'], function () {
    // $.livereload.listen();
    gulp.watch([sassSources], ['sass']);
    // gulp.watch([jsSources], ['reload']);
    // gulp.watch([htmlSources], ['reload']);
});
