var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    stylus = require('gulp-stylus'),
    sourceMaps = require('gulp-sourcemaps'),
    cleanCss = require('gulp-clean-css');
    
    
gulp.task('default', ['adminJavaScript', 'frontJavaScript', 'stylus', 'minimizeCss'], function () {
	gulp.watch('dev/js/admin/*.js', ['adminJavaScript']);
	gulp.watch('dev/js/front/*.js', ['frontJavaScript']);
	gulp.watch('dev/css/stylus/**/**/*.styl', ['stylus']);
        gulp.watch('views/css/*.css', ['minimizeCss']);
        

});

gulp.task('adminJavaScript', function () {
	
	return gulp.src('dev/js/admin/*.js')
		
		.pipe(concat('testAdmin.js'))

		.pipe(uglify())
        
    		.pipe(gulp.dest('views/js/'));
});

gulp.task('frontJavaScript', function () {
	
	return gulp.src('dev/js/front/*.js')
		
		.pipe(concat('testFront.js'))

		.pipe(uglify())
        
                .pipe(sourceMaps.init({loadMaps: true}))
                .pipe(sourceMaps.write())

		.pipe(gulp.dest('views/js/'));
});

gulp.task('stylus', function() {
	return gulp.src('dev/css/stylus/mymodule.styl')
		.pipe(stylus())
		.pipe(gulp.dest('views/css/'));
});

gulp.task('minimizeCss', function () {
	return gulp.src('views/css/*.css')
		.pipe(sourceMaps.init())
		.pipe(cleanCss({degub: true}, function(details) {
			console.log(details.name + ': ' + details.stats.originalSize);
			console.log(details.name + ': ' + details.stats.minifiedSize);
		}))
		.pipe(sourceMaps.write())
		.pipe(gulp.dest('views/css/'));
});

