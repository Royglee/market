var elixir = require('laravel-elixir');
var autoprefixer = require('gulp-autoprefixer');
var gulp = require('gulp');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

gulp.task('autoprefix', function () {
    return gulp.src('public/css/style.css')
        .pipe(autoprefixer())
        .pipe(gulp.dest('public/css'));
});
elixir(function(mix) {
    mix.less('style.less');
    mix.task('autoprefix')
    mix.styles([
        'resources/assets/normalize.css',
        'public/css/style.css'
    ], 'public/css/app.css', './');
});