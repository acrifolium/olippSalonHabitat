var gulp = require("gulp")
var paths = require("../paths")

/**
 * watch task
 *
 * watch sources to dynamically build files whenever it's needed
 * used for development
 */
module.exports = function () {

    gulp.watch(paths.sources.scripts, ["scripts"])

    gulp.watch(paths.sources.stylesheets, ["css"])

    gulp.watch(paths.sources.images, ["assets"])

    gulp.watch(paths.sources.api, ["assets"])

    gulp.watch(paths.sources.public, ["public"])

    gulp.watch(paths.sources.app_data, ["assets"])

    gulp.watch(paths.sources.partialsWatch, ["public"])
}