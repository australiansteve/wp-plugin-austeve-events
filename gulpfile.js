// Load our plugins
var	gulp			=	require('gulp'),
	sass			=	require('gulp-sass'),  // Our sass compiler
	notify			=	require('gulp-notify'), // Basic gulp notificatin using OS
	minifycss		=	require('gulp-minify-css'), // Minification
	rename			=	require('gulp-rename'), // Allows us to rename our css file prior to minifying
	autoprefixer	=	require('gulp-autoprefixer'), // Adds vendor prefixes for us
	concat			= require('gulp-concat'), // Concat our js
	uglify			= require('gulp-uglify'), // Minify our js
	jshint 			= require('gulp-jshint'); // Checks for js errors


// Our 'styles' tasks, which handles our sass actions such as compliling and minification

gulp.task('styles', function() {
		gulp.src('./style.scss')
		.pipe(sass({
			style: 'expanded',
			sourceComments: true
		})
		.on('error', notify.onError(function(error) {
			return "Error: " + error.message;
		}))
		)
		.pipe(autoprefixer({
			browsers: ['last 2 versions', 'ie >= 8']
		})) // our autoprefixer - add and remove vendor prefixes using caniuse.com
		.pipe(gulp.dest('.')) // Location of our style.css file
		.pipe(notify({
			message: "Styles task complete!"
		}));
});

//Our 'deploy' task which deploys on a local dev environment

gulp.task('deploylocal', function() {

	var files = [
		'page-templates/**/*.php',
		'js/**/*.js',
		'*.php',
		'*.css'];

	var dest = '/var/www/html/theme-dev/wp-content/plugins/austeve-projects';

	return gulp.src(files, {base:"."})
	        .pipe(gulp.dest(dest));
});

// Our default gulp task, which runs all of our tasks upon typing in 'gulp' in Terminal
gulp.task('default', ['styles', 'deploylocal']);
