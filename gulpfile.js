const { src, dest, parallel, watch } = require("gulp")
const sass = require("gulp-sass")(require("sass"))
const cssnano = require("cssnano")
const postcss = require("gulp-postcss")
const autoprefixer = require("autoprefixer")
const concat = require("gulp-concat")
const terser = require("gulp-terser-js")
const paths = {
  sass: "src/sass/**/*.scss",
  js: "src/js/**/*.js",
}

function css() {
  return src(paths.sass)
    .pipe(sass())
    .pipe(postcss([cssnano(), autoprefixer()]))
    .pipe(dest("public/css"))
}

function js() {
  return src(paths.js)
    .pipe(concat("app.js"))
    .pipe(terser())
    .pipe(dest("public/js"))
}

function watchall() {
  watch(paths.sass, css)
  watch(paths.js, js)
}

exports.css = css
exports.js = js
exports.default = parallel(css, js, watchall)
