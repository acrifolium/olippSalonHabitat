var gulp = require("gulp")
var opts = require("./options")
var util = require("gulp-util")
var plumber = require("gulp-plumber")
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var gulpif = require('gulp-if');
var merge = require('merge-stream');
var paths = require("../paths")
var bundleConfig = require("../bundleConfig")

/**
 * task scripts
 *
 * Dist scripts to public folder
 */
module.exports = function () {
console.log('path', paths.sources.scripts);
    // Dist local scripts
    var scripts = gulp.src([paths.sources.scripts])
                      .pipe(opts.plumber ? plumber() : util.noop())
                      //.pipe(concat('salon.js'))
                      //.pipe(uglify())
                      .pipe(gulp.dest(paths.dist.libs))

    // Dist external scripts
    var lib = gulp.src(bundleConfig.jsExternal, { cwd: paths.sources.bower })
                  .pipe(opts.plumber ? plumber() : util.noop())
                  .pipe(gulp.dest(paths.dist.libs))

    return merge(scripts, lib);
}