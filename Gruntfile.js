module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'vendor_js',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/jquery.min.js': 'jquery/dist/jquery.min.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js',
                    'js/bootstrap.min.js': 'bootstrap/dist/js/bootstrap.min.js',
                    'js/angular.js': 'angular/angular.js',
                    'js/angular.min.js': 'angular/angular.min.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'bootstrap/dist/fonts'
                }
            }

        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.registerTask('default', ['bowercopy']);
};
