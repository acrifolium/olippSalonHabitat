var gulp = require("gulp")
var opts = require("./options")
var util = require("gulp-util")
var plumber = require("gulp-plumber")
var cssnext = require("gulp-cssnext")
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var less = require('gulp-less');
var minify = require('gulp-minify-css');
var rename = require('gulp-rename');
var path = require('path');
var merge = require('merge-stream');
var paths = require("../paths")
var bundleConfig = require("../bundleConfig")

/**
 * task stylesheets
 *
 * cssnext -> css
 */
module.exports = function () {

    // Dist local stylesheets
    var localCss = gulp.src(paths.sources.stylesheets)
            .pipe(opts.plumber ? plumber() : util.noop())
            .pipe(less({
                paths: [path.join(__dirname, 'less', 'includes')]
            }))
            .pipe(autoprefixer())
            .pipe(cssnext({ sourcemap: false }))
            .pipe(concat('salon.css'))
            .pipe(minify())
            .pipe(gulp.dest(paths.dist.stylesheets))

    // Dist external stylesheets
    var libCss = gulp.src(bundleConfig.cssExternal, { cwd: paths.sources.bower })
        .pipe(opts.plumber ? plumber() : util.noop())
            .pipe(less({
                paths: [path.join(__dirname, 'less', 'includes')]
            }))
            .pipe(autoprefixer())
            .pipe(cssnext({ sourcemap: false }))
            .pipe(gulp.dest(paths.dist.stylesheets))

    return merge(localCss, libCss);

    /*return merge(localCss);*/
}