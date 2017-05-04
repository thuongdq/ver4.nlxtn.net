// ////////////////////////////////////////////////
//
// EDIT CONFIG OBJECT BELOW !!!
// 
// jsConcatFiles => list of javascript files (in order) to concatenate
// buildFilesFoldersRemove => list of files to remove when running final build
// // //////////////////////////////////////////////

var config = {
    cssListenFiles: [
        'app/css/**/*.css',
        '!app/css/app.bundle.min.css'
    ],
    cssConcatFiles: [
        // 'app/css/**/*.css',
        'app/css/bootstrap-import.css',
        'app/bower_components/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.css',
        'app/css/header.css',
        'app/css/left.css',
        'app/css/content.css',
        'app/css/right.css',
        'app/css/footer.css',
        'app/css/responsive.css',
        '!app/css/app.bundle.css'
    ],
    jsListenFiles: [
        'app/js/**/*.js',
        '!app/js/**/*.min.js',
        '!app/js/app.bundle.js'
    ],
    jsConcatFiles: [
        'app/bower_components/Jquery-ex/jquery.min.js',
        'app/js/**/*.js',
        // 'app/js/lib.run.js',
        // 'app/js/main.js',
        'app/bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.min.js',
        'app/bower_components/smartmenus/jquery.smartmenus.js',
        'app/bower_components/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.js',
        // 'app/bower_components/lightslider-master/src/js/lightslider.js',
        '!app/js/app.bundle.js'
    ],
    htmlListenFiles: [
        'app/**/*.html',
        // 'app/trang-chu.html',
        // 'app/index.html'
    ],
    buildFilesFoldersRemove: [
        'build/scss/',
        'build/js/!(*.min.js)',
        'build/bower.json',
        'build/bower_components/',
        'build/maps/'
    ]
};

// ////////////////////////////////////////////////
// Required taskes
// gulp build
// bulp build:serve
// // /////////////////////////////////////////////
var gulp = require('gulp'),
    plumber = require('gulp-plumber'), //fix pipe
    autoprefixer = require('gulp-autoprefixer'), //report css
    browserSync = require('browser-sync'),
    reload = browserSync.reload,
    cleanCSS = require('gulp-clean-css'), //minify css
    uglify = require('gulp-uglify'), //minify js
    sass = require('gulp-sass'), //compile Sass->css
    del = require('del'),
    rename = require('gulp-rename'), //rename file
    concat = require('gulp-concat');

// Bootstrap scss source
var bootstrapSass = { in: 'app/bower_components/bootstrap-sass-official/'
};

// fonts
var fonts = { in: ['app/fonts/*.*', bootstrapSass.in + 'assets/fonts/**/*'],
    out: 'app/fonts/'
};

// css source file: .scss files
var css = { in: 'app/scss/**/*.scss',
    out: 'app/css/',
    watch: 'app/css/**/*',
    sassOpts: {
        outputStyle: 'nested',
        precison: 3,
        errLogToConsole: true,
        includePaths: [bootstrapSass.in + 'assets/stylesheets']
    }
};

// copy bootstrap required fonts to dest
gulp.task('fonts', function() {
    return gulp
        .src(fonts.in)
        .pipe(gulp.dest(fonts.out));
});

// compile scss
gulp.task('sass', ['fonts'], function() {
    return gulp.src(css.in)
        .pipe(sass(css.sassOpts))
        .pipe(gulp.dest(css.out));
});


// ////////////////////////////////////////////////
// Scripts Tasks
// ///////////////////////////////////////////////
gulp.task("min-scripts", function() {
    gulp.src(config.jsListenFiles)
        .pipe(plumber())
        .pipe(rename({ suffix: '.min' }))
        .pipe(concat('app.bundle.js'))
        .pipe(uglify())
        .pipe(gulp.dest('app/js'));
});

gulp.task("scripts", function() {
    gulp.src(config.jsConcatFiles)
        .pipe(plumber())
        .pipe(concat('app.bundle.js'))
        .pipe(uglify())
        .pipe(gulp.dest('app/js'))
        .pipe(reload({ stream: true }));
});

// ////////////////////////////////////////////////
// Styles Tasks
// ///////////////////////////////////////////////
gulp.task("min-styles", function() {
    gulp.src(config.cssListenFiles)
        .pipe(plumber())
        .pipe(rename({ suffix: '.min' }))
        .pipe(cleanCSS({ compatibility: 'ie8+' }))
        .pipe(gulp.dest('app/css'))
        .pipe(reload({ stream: true }));
});

gulp.task("styles", function() {
    gulp.src(config.cssConcatFiles)
        .pipe(plumber())
        .pipe(rename({ suffix: '.min' }))
        .pipe(concat('app.bundle.css'))
        .pipe(cleanCSS({ compatibility: 'ie8' }))
        .pipe(gulp.dest('app/css'))
        .pipe(reload({ stream: true }));
});

// ////////////////////////////////////////////////
// Compass / Sass Tasks
// ///////////////////////////////////////////////
gulp.task('compass', function() {
    gulp.src(['app/scss/**/*.scss'])
        .pipe(plumber())
        .pipe(sass(css.sassOpts))
        .pipe(autoprefixer('last 2 versions'))
        .pipe(gulp.dest('app/css/'))
        .pipe(reload({ stream: true }));
});

// ////////////////////////////////////////////////
// HTML Tasks
// ///////////////////////////////////////////////
gulp.task('html', function() {
    gulp.src(config.htmlListenFiles)
        .pipe(reload({ stream: true }));
});

// ////////////////////////////////////////////////
// Browser-Sync Tasks
// ///////////////////////////////////////////////
gulp.task('browser-sync', function() {
    // browserSync.init({
    //     // open: 'external',
    //     host: "localhost",
    //     proxy: "localhost/gulp/app",
    //     port: 80,
    //     online: true
    // });
    browserSync({
        server: {
            baseDir: './app/'
        }
    });
});

// task to run build server for testing final app
gulp.task('build:serve', function() {
    browserSync({
        server: {
            baseDir: "./build/"
        }
    });
});


// ////////////////////////////////////////////////
// Build Tasks
// // /////////////////////////////////////////////

// clean out all files and folders from build folder
gulp.task('build:cleanfolder', function() {
    del([
        'build/**'
    ]);
});

// task to create build directory of all files
gulp.task('build:copy', ['build:cleanfolder'], function() {
    return gulp.src('app/**/*/')
        .pipe(gulp.dest('build/'));
});

// task to removed unwanted build files
// list all files and directories here that you don't want included
gulp.task('build:remove', ['build:copy'], function(cb) {
    del([
        'build/bower_components',
        'build/scss/',
        'build/css/!(app.bundle.css)',
        'build/js/!(app.bundle.js)',
        // 'build/js/!(*.min.js)',
    ], cb);
});

gulp.task('build', ['build:copy', 'build:remove']);

// ////////////////////////////////////////////////
// Watch Tasks
// // /////////////////////////////////////////////
gulp.task('watch', function() {
    gulp.watch('app/scss/**/*.scss', ['compass']);
    gulp.watch(config.jsConcatFiles, ['scripts']);
    gulp.watch(config.cssListenFiles, ['min-styles']);
    gulp.watch(config.htmlListenFiles, ['html']);
})

// ////////////////////////////////////////////////
// Default Tasks
// ///////////////////////////////////////////////
gulp.task('default', ['scripts', 'compass', 'min-styles', 'fonts', 'html', 'browser-sync', 'watch']);