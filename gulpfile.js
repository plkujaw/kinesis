const package = require('./package.json');

const autoprefixer = require('autoprefixer');
const browserSync = require('browser-sync').create();
const cssnano = require('cssnano');
const gulp = require('gulp');
const postcss = require('gulp-postcss');
const reload = browserSync.reload;
const rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');

const webpack = require('webpack-stream');

const src = {
  sass: {
    main: 'assets/src/scss/main.scss',
    partials: ['assets/src/scss/**/*.scss', '!assets/src/scss/blocks/*.scss'],
    blocks: ['assets/src/scss/blocks/*.scss'],
  },
  js: {
    partials: ['assets/src/js/**/*.js'],
  },
  php: ['./**/*.php'],
};

function processSASS() {
  return gulp
    .src(src.sass.main)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(sourcemaps.write())
    .pipe(rename('main.min.css'))
    .pipe(gulp.dest('assets/dist/css'));
}

function processBlocks() {
  return gulp
    .src(src.sass.blocks)
    .pipe(sourcemaps.init())
    .pipe(
      rename((path) => {
        path.dirname += '/' + path.basename;
        path.basename = path.basename + '.min';
      })
    )
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('inc/template-parts/blocks/'));
}

function processJS() {
  return gulp
    .src('.')
    .pipe(webpack(require('./webpack.config.js')))
    .pipe(gulp.dest('assets/dist/js'));
}

function watchSASS() {
  return gulp.watch(
    src.sass.partials,
    { ignoreInitial: true, awaitWriteFinish: true },
    gulp.series(processSASS)
  );
}
function watchBlocks() {
  return gulp.watch(
    src.sass.blocks,
    { ignoreInitial: true, awaitWriteFinish: true },
    gulp.series(processBlocks)
  );
}

function watchJS() {
  return gulp.watch(
    src.js.partials,
    { ignoreInitial: true, awaitWriteFinish: true },
    gulp.series(processJS)
  );
}

function watchPHP() {
  return gulp.watch(src.php);
}

gulp.task('watch', async () => {
  watchSASS();
  watchBlocks();
  watchJS();
  watchPHP();
});

gulp.task('sync', async () => {
  browserSync.init({
    proxy: `http://${package.name}.local/`,
  });
  watchSASS().on('change', reload);
  watchBlocks().on('change', reload);
  watchJS().on('change', reload);
  watchPHP().on('change', reload);
});

exports.build = gulp.parallel(processSASS, processBlocks, processJS);
