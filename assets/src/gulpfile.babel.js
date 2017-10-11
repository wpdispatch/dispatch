/**
 *
 *  Web Starter Kit
 *  Copyright 2015 Google Inc. All rights reserved.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License
 *
 */

'use strict';

// This gulpfile makes use of new JavaScript features.
// Babel handles this without us having to do anything. It just works.
// You can read more about the new JavaScript features here:
// https://babeljs.io/docs/learn-es2015/

import path from 'path';
import gulp from 'gulp';
import util  from 'gulp-util';
import del from 'del';
import runSequence from 'run-sequence';
import browserSync from 'browser-sync';
import swPrecache from 'sw-precache';
import gulpLoadPlugins from 'gulp-load-plugins';
import {output as pagespeed} from 'psi';
import pkg from './package.json';

import postcss from 'gulp-postcss';
import svgSprite from 'gulp-svg-sprite';
import sassInlineSvg from 'gulp-sass-inline-svg';

var config = {
    dev: !!util.env.dev,
    dist: !util.env.dev,
    build: !!util.env.build
};

const $ = gulpLoadPlugins();
const reload = browserSync.reload;

// Lint JavaScript
gulp.task('lint', () =>
  gulp.src(['./js/**/*.js','!node_modules/**'])
    .pipe($.eslint())
    .pipe($.eslint.format())
    .pipe($.if(!browserSync.active, $.eslint.failAfterError()))
);

// Optimize images
gulp.task('images', () =>
  gulp.src('./images/**/*')
    .pipe($.cache($.imagemin({
      progressive: true,
      interlaced: true
    })))
    .pipe(gulp.dest('../dist/images'))
    .pipe($.size({title: 'images'}))
);

// Optimize icons
gulp.task('icons', () => {
  gulp.dest('../.tmp');
  return gulp.src('./icons/*.svg')
    .pipe($.newer('../.tmp/icons'))
    .pipe(svgSprite({
      shape: {
        dest: './',
        dimension: {
          maxWidth: 48,
          maxHeight: 48
        },
        spacing: {
          padding: 0
        },
      },
      svg: {
        namespaceClassnames: false,
        rootAttributes: {
          'class': function(name) {
            return 'icon icon-' + path.basename(name, '.svg')
          }
        }
      }
    }))
    .pipe(gulp.dest('../dist/icons'))
    .pipe(gulp.dest('../.tmp/icons'))
    .pipe(sassInlineSvg({
      destDir: '../.tmp'
    }))
});

// Copy all files at the root level (app)
// gulp.task('copy', () =>
//   gulp.src([
//     'app/*',
//     '!app/*.html',
//     'node_modules/apache-server-configs/dist/.htaccess'
//   ], {
//     dot: true
//   }).pipe(gulp.dest('dist'))
//     .pipe($.size({title: 'copy'}))
// );

const AUTOPREFIXER_BROWSERS = [
  'ie >= 10',
  'ie_mob >= 10',
  'ff >= 30',
  'chrome >= 34',
  'safari >= 7',
  'opera >= 23',
  'ios >= 7',
  'android >= 4.4',
  'bb >= 10'
];

// Compile and automatically prefix stylesheets
gulp.task('styles.app', () => {

  // For best performance, don't add Sass partials to `gulp.src`
  return gulp.src(pkg.build.styles.app)
    .pipe($.newer('../.tmp/css'))
    .pipe(config.dev ? $.sourcemaps.init() : util.noop())
    .pipe($.sass({
      precision: 10
    }).on('error', $.sass.logError))
    .pipe(postcss([require('postcss-object-fit-images')]))
    .pipe($.autoprefixer(AUTOPREFIXER_BROWSERS))
    .pipe(gulp.dest('../.tmp/css'))
    // Concatenate and minify styles
    .pipe(config.dist ? $.if('*.css', $.cssnano({
            discardComments: {removeAll: true}
        })) : util.noop())
    .pipe($.size({title: 'css'}))
    .pipe(config.dev ? $.sourcemaps.write('./') : util.noop())
    .pipe(gulp.dest('../dist/css'))
    .pipe(gulp.dest('../.tmp/css'));
});

// Compile and automatically prefix stylesheets
gulp.task('styles.vendor', () => {
  // For best performance, don't add Sass partials to `gulp.src`
  return gulp.src(pkg.build.styles.vendor)
    .pipe($.newer('../.tmp/css'))
    .pipe(config.dev ? $.sourcemaps.init() : util.noop())
    .pipe($.sass({
      precision: 10
    }).on('error', $.sass.logError))
    .pipe(postcss([require('postcss-object-fit-images')]))
    .pipe($.autoprefixer(AUTOPREFIXER_BROWSERS))
    .pipe(gulp.dest('../.tmp/css'))
    // Concatenate and minify styles
    .pipe(config.dist ? $.if('*.css', $.cssnano({
            discardComments: {removeAll: true}
        })) : util.noop())
    .pipe($.size({title: 'css'}))
    .pipe(config.dev ? $.sourcemaps.write('./') : util.noop())
    .pipe(gulp.dest('../dist/css'))
    .pipe(gulp.dest('../.tmp/css'));
});

// Concatenate and minify JavaScript. Optionally transpiles ES2015 code to ES5.
// to enable ES2015 support remove the line `"only": "gulpfile.babel.js",` in the
// `.babelrc` file.
gulp.task('scripts.app', () => {
  if (!pkg.build.scripts.app.length) return;
  return gulp.src(pkg.build.scripts.app)
    .pipe($.newer('../.tmp/js'))
    .pipe(config.dev ? $.sourcemaps.init() : util.noop())
    .pipe($.babel())
    .pipe(config.dev ? $.sourcemaps.write() : util.noop())
    .pipe(gulp.dest('../.tmp/js'))
    .pipe($.concat('app.js'))
    .pipe(config.dist ? $.uglify({output: {comments: false}}) : util.noop())
    // Output files
    .pipe($.size({title: 'js'}))
    .pipe(config.dev ? $.sourcemaps.write('.') : util.noop())
    .pipe(gulp.dest('../dist/js'))
    .pipe(gulp.dest('../.tmp/js'))
});

// Concatenate and minify JavaScript. Optionally transpiles ES2015 code to ES5.
// to enable ES2015 support remove the line `"only": "gulpfile.babel.js",` in the
// `.babelrc` file.
gulp.task('scripts.vendor', () => {
  if (!pkg.build.scripts.vendor.length) return;
  return gulp.src(pkg.build.scripts.vendor)
    .pipe($.newer('../.tmp/js'))
    .pipe(config.dev ? $.sourcemaps.init() : util.noop())
    .pipe($.babel())
    .pipe(config.dev ? $.sourcemaps.write() : util.noop())
    .pipe(gulp.dest('../.tmp/js'))
    .pipe($.concat('vendor.js'))
    .pipe(config.dist ? $.uglify({output: {comments: false}}) : util.noop())
    // Output files
    .pipe($.size({title: 'js'}))
    .pipe(config.dev ? $.sourcemaps.write('.') : util.noop())
    .pipe(gulp.dest('../dist/js'))
    .pipe(gulp.dest('../.tmp/js'))
});

// Clean output directory
gulp.task('clean', () => del(['../.tmp', '../dist/*', '!../dist/.git'], {dot: true, force: true}));

// Watch files for changes & reload
gulp.task('serve', (config.build ? ['default'] : [] ), () => {
  /*
  config.dist = false;
  config.dev = true;
  */
  browserSync({
    // notify: false,
    // Customize the Browsersync console logging prefix
    logPrefix: 'WSK',
    // Allow scroll syncing across breakpoints
    // scrollElementMapping: ['main', '.mdl-layout'],
    // Run as an https by uncommenting 'https: true'
    // Note: this uses an unsigned certificate which on first access
    //       will present a certificate warning in the browser.
    // https: true,
    // server: ['.tmp', 'app'],
    // port: 3000
    proxy: pkg.dev_url
  });

  // gulp.watch(['app/**/*.html'], reload);
  gulp.watch(['./scss/**/*.scss', '!./scss/vendor.scss'], ['styles.app', reload]);
  // gulp.watch(['app/scripts/**/*.js'], ['lint', 'scripts', reload]);
  gulp.watch(['./js/**/*.js'], ['scripts.app', reload]);
  gulp.watch(['./images/**/*'], reload);
});

// Build production files, the default task
gulp.task('styles', [], cb => {
  runSequence(
    ['styles.app', 'styles.vendor'],
    // 'generate-service-worker',
    cb
  )
});

// Build production files, the default task
gulp.task('scripts', [], cb => {
  runSequence(
    ['scripts.app', 'scripts.vendor'],
    // 'generate-service-worker',
    cb
  )
});

// Build production files, the default task
gulp.task('default', ['clean'], cb => {
  runSequence(
    ['icons'],
    ['styles.app', 'styles.vendor'],
    ['scripts.app', 'scripts.vendor'],
    ['images'],
    // 'generate-service-worker',
    cb
  )
});

// Run PageSpeed Insights
gulp.task('pagespeed', cb => {
  // Update the below URL to the public URL of your site
  pagespeed(pkg.live_url, {
    strategy: 'mobile'
    // By default we use the PageSpeed Insights free (no API key) tier.
    // Use a Google Developer API key if you have one: http://goo.gl/RkN0vE
    // key: 'YOUR_API_KEY'
  }, cb)
});

// Copy over the scripts that are used in importScripts as part of the generate-service-worker task.
// gulp.task('copy-sw-scripts', () => {
//   return gulp.src(['node_modules/sw-toolbox/sw-toolbox.js', 'app/scripts/sw/runtime-caching.js'])
//     .pipe(gulp.dest('dist/scripts/sw'));
// });

// See http://www.html5rocks.com/en/tutorials/service-worker/introduction/ for
// an in-depth explanation of what service workers are and why you should care.
// Generate a service worker file that will provide offline functionality for
// local resources. This should only be done for the 'dist' directory, to allow
// live reload to work as expected when serving from the 'app' directory.
// gulp.task('generate-service-worker', ['copy-sw-scripts'], () => {
//   const rootDir = 'dist';
//   const filepath = path.join(rootDir, 'service-worker.js');

//   return swPrecache.write(filepath, {
//     // Used to avoid cache conflicts when serving on localhost.
//     cacheId: pkg.name || 'web-starter-kit',
//     // sw-toolbox.js needs to be listed first. It sets up methods used in runtime-caching.js.
//     importScripts: [
//       'scripts/sw/sw-toolbox.js',
//       'scripts/sw/runtime-caching.js'
//     ],
//     staticFileGlobs: [
//       // Add/remove glob patterns to match your directory setup.
//       `${rootDir}/images/**/*`,
//       `${rootDir}/scripts/**/*.js`,
//       `${rootDir}/styles/**/*.css`,
//       `${rootDir}/*.{html,json}`
//     ],
//     // Translates a static file path to the relative URL that it's served from.
//     // This is '/' rather than path.sep because the paths returned from
//     // glob always use '/'.
//     stripPrefix: rootDir + '/'
//   });
// });

// Load custom tasks from the `tasks` directory
// Run: `npm install --save-dev require-dir` from the command-line
// try { require('require-dir')('tasks'); } catch (err) { console.error(err); }
