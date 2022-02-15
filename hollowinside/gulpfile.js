'use strict';

const gulp = require('gulp'),
    babel = require('gulp-babel'),
    concat = require('gulp-concat'),
    cleancss = require('gulp-clean-css'),
    uglify = require('gulp-uglify-es').default,
    sass = require('gulp-sass')(require('sass')),
    clean = require('gulp-clean'),
    purgecss = require('gulp-purgecss'),
    rename = require('gulp-rename'),
    merge = require('merge-stream'),
    injectstring = require('gulp-inject-string'),
    imagemin = require('gulp-imagemin'),
    bundleconfig = require('./bundleconfig.json'),
    fs = require('fs');

const { series, parallel, src, dest, watch } = require('gulp');

const regex = {
    css: /\.css$/,
    js: /\.js$/
};

const paths = {
    output: 'output/',
    outputAssets: 'output/assets/',
    inputAssets: 'assets/',
    node_modules: 'node_modules/'
};

const getBundles = (regexPattern) => {
    return bundleconfig.filter(bundle => {
        return regexPattern.test(bundle.outputFileName);
    });
};
  
function delStart() {
    return src([
        paths.output
        ], { allowEmpty: true })
        .pipe(clean({ force: true }));
}

function copyAssets() {
    var copyFontAwesome = src(paths.node_modules + '@fortawesome/fontawesome-free/webfonts/*.*')
        .pipe(dest(paths.outputAssets + 'fonts/fontawesome-free'));

    var copyImages = src(paths.inputAssets + 'images/**/*.*')
        .pipe(imagemin())
        .pipe(dest(paths.outputAssets + 'images'));

    var copyIcons = src('*.png')
        .pipe(imagemin())
        .pipe(dest(paths.output));

    var copyManifest = src('site.webmanifest')
        .pipe(dest(paths.output));

    var copyRootPhp = src('*.php')
        .pipe(dest(paths.output));

    var copyIncPhp = src('inc/*.php')
        .pipe(dest(paths.output + 'inc'));

    var copyTemplatePartsPhp = src('template-parts/*.php')
        .pipe(dest(paths.output + 'template-parts'));

    return merge(copyFontAwesome, copyImages, copyIcons, copyManifest, copyRootPhp, copyIncPhp, copyTemplatePartsPhp);
}

function compileScss() {
    return src(paths.inputAssets + 'css/scss/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(dest(paths.outputAssets + 'css'));
}

function concatJs() {
    var tasks = getBundles(regex.js).map(function (bundle) {
        return src(bundle.inputFiles, { base: '.' })
            .pipe(babel({
                "sourceType": "unambiguous",
                "presets": [
                    ["@babel/preset-env", {
                        "targets": {
                            "ie": "10"
                        }
                    }
                    ]]
            }))
            .pipe(concat(bundle.outputFileName))
            .pipe(dest('.'));
    });

    return merge(tasks);
}

function concatCss() {
    var tasks = getBundles(regex.css).map(function (bundle) {

        return src(bundle.inputFiles, { base: '.' })
            .pipe(concat(bundle.outputFileName))
            .pipe(dest('.'));
    });

    return merge(tasks);
}

function purgeCss() {
    return src(paths.outputAssets + 'css/main.bundle.css')
        .pipe(purgecss({
            content: [
                '*.php',
                'inc/*.php',
                'template-parts/*.php',
                paths.outputAssets + 'js/*.*'
            ],
            safelist: [
                '::-webkit-scrollbar',
                '::-webkit-scrollbar-thumb'
            ],
            keyframes: true,
            variables: true
        }))
        .pipe(dest(paths.outputAssets + 'css/'));
}

function minCss() {
    var tasks = getBundles(regex.css).map(function (bundle) {

        return src(bundle.outputFileName, { base: '.' })
            .pipe(cleancss({
                level: 2,
                compatibility: 'ie8'
            }))
            .pipe(rename({ 
                dirname: './',
                basename: 'style' 
            }))
            //.pipe(dest(paths.output)); // use this for final
            .pipe(dest('.'));
    });

    return merge(tasks);
}

function minJs() {
    var tasks = getBundles(regex.js).map(function (bundle) {

        return src(bundle.outputFileName, { base: '.' })
            .pipe(uglify())
            .pipe(dest('.'));
    });

    return merge(tasks);
}

function delEnd() {
    return src([
        paths.outputAssets + 'css/main.*'
    ], { allowEmpty: true })
        .pipe(clean({ force: true }));
}

// Gulp series
exports.concatScssJs = parallel(compileScss, concatJs);
exports.minCssJs = parallel(minCss, minJs);

// Gulp default
exports.default = series(delStart, copyAssets, exports.concatScssJs, concatCss, purgeCss, exports.minCssJs, delEnd);