import { src, dest, watch, series, parallel } from 'gulp';

//import a package that will allow us to define these types of arguments while running a command.
import yargs from 'yargs';

//import packages that will be responsible for compiling, minifying, conditionally running tasks
import sass from 'gulp-sass';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';

//import packages that will be responsible for mapping, adding prefixes - (not work)
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';

//import a package that will be responsible for deleting the dist folder
import del from 'del';

//import webpack-stream that will allow us to use webpack within a Gulp task
import webpack from 'webpack-stream';

//Retrieve these argument in the Gulpfile after adding argument to the command
const PRODUCTION = yargs.argv.prod;

//import browserSync that will allow us to refresh the browser each time tasks finish running.
import browserSync from "browser-sync";

//Creating the style task
export const styles = () => {
  return src('src/scss/bundle.scss')
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpif(PRODUCTION, postcss([ autoprefixer() ])))
    .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(dest('dist/css'));
}

//Creating the copy task
export const copy = () => {
  return src(['src/**/*','!src/{images,js,scss}','!src/{images,js,scss}/**/*'])
    .pipe(dest('dist'));
}

//Creating the watch task
export const watchForChanges = () => {
  watch('src/scss/**/*.scss', series(styles, reload));
  watch(['src/**/*','!src/{images,js,scss}','!src/{images,js,scss}/**/*'], series(copy, reload));
  watch('src/js/**/*.js', series(scripts, reload));
}

//Creating clean task
export const clean = () => del(['dist']);



//Creating the script task
export const scripts = () => {
  return src('src/js/bundle.js')
  .pipe(webpack({
    module: {
      rules: [
        {
          test: /\.js$/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: []
            }
          }
        }
      ]
    },
    mode: PRODUCTION ? 'production' : 'development',
    devtool: !PRODUCTION ? 'inline-source-map' : false,
    output: {
      filename: 'bundle.js'
    },
  }))
  .pipe(dest('dist/js'));
}

//Initialize a Browsersync server and write two new tasks
const server = browserSync.create();
export const serve = done => {
  server.init({
    browser: "google chrome",
    proxy: "localhost:3000",
    notify: false,
    proxy: "http://chateaubrooklyn.com/work-clients/" // put your local website link here
  });
  done();
};
export const reload = done => {
  server.reload();
  done();
};

//Create two new tasks by composing the tasks that we already created
export const dev = series(clean, parallel(styles, copy, scripts), serve, watchForChanges)
export const build = series(clean, parallel(styles, copy, scripts))
export default dev;
