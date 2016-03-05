var paths = require("../paths")
var gulp = require('gulp');
var bower = require('gulp-bower');

/**
 * task bower:install
 *
 * install bower dependency
 */
module.exports = function () {
    return bower()
        .pipe(gulp.dest(paths.sources.bower));
}