var gulp = require('gulp');
var tasks = './gulp/tasks/';

gulp.task("clean", require(tasks + "clean"))

// install bower
gulp.task("bower:install", require(tasks + "bower"))

// static assets
gulp.task("public", require(tasks + "public"))
gulp.task("assets", require(tasks + "assets"))

// generated assets
gulp.task("scripts", require(tasks + "scripts")) 

// generated css
gulp.task("css", require(tasks + "/stylesheets"))

// inject
///gulp.task("inject", ["scripts", "stylesheets"], require(tasks + "/inject"))
///gulp.task("inject:all", ["combine"], require(tasks + "/inject"))

// build
gulp.task("dist", [
  "clean",
  "bower:install",

  "public",
  "assets",

  "scripts",
  "css",
])

// Init
gulp.task("init", [
  "clean",
  "bower:install"
])

// dev tasks
gulp.task("watch", require(tasks + "watch"))
gulp.task("watch:all", ["dist"], require(tasks + "watch"))
gulp.task("default", [
  "dist",
  "watch"
])
