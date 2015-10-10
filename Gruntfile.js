module.exports = function (grunt) {

    //Initializing the configuration object
    grunt.initConfig({

        // Task configuration
        less: {
            development: {
                options: {
                    compress: true,  //minifying the result
                },
                files: {
                    //compiling frontend.less into frontend.css
                    "web/assets/css/bootstrap-frontend.min.css": "vendor_js/bootstrap/custom/frontend/bootstrap/custom-bootstrap.less",
                    "web/assets/css/bootstrap-theme-frontend.min.css": "vendor_js/bootstrap/custom/frontend/theme/custom-theme.less",
                    //compiling backend.less into backend.css
                    "web/assets/css/bootstrap-backend.min.css": "vendor_js/bootstrap/custom/backend/bootstrap/custom-bootstrap.less",
                    "web/assets/css/bootstrap-theme-backend.min.css": "vendor_js/bootstrap/custom/backend/theme/custom-theme.less"
                }
            }
        },
        bowercopy: {
            options: {
                srcPrefix: 'vendor_js',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/jquery.min.js': 'jquery/dist/jquery.min.js',
                    'js/jquery-ui.js': 'jquery-ui/jquery-ui.js',
                    'js/jquery-ui.min.js': 'jquery-ui/jquery-ui.min.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js',
                    'js/bootstrap.min.js': 'bootstrap/dist/js/bootstrap.min.js',
                    'js/angular.js': 'angular/angular.js',
                    'js/angular.min.js': 'angular/angular.min.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
                    'css/bootstrap.min.css': 'bootstrap/dist/css/bootstrap.min.css',
                    'css/bootstrap-theme.css': 'bootstrap/dist/css/bootstrap-theme.css',
                    'css/bootstrap-theme.min.css': 'bootstrap/dist/css/bootstrap-theme.min.css'
                }
            },
            fonts: {
                files: {
                    'fonts': 'bootstrap/dist/fonts'
                }
            }

        },
        watch: {
            less: {
                files: ['vendor_js/bootstrap/custom/backend/bootstrap/*.less',
                    'vendor_js/bootstrap/custom/backend/theme/*.less',
                    'vendor_js/bootstrap/custom/frontend/bootstrap/*.less',
                    'vendor_js/bootstrap/custom/frontend/theme/*.less',
                ],  //watched files
                tasks: ['bowercopy', 'less'],                          //tasks to run
                options: {
                    livereload: true                        //reloads the browser
                }
            }
        }
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');

    // Task definition
    grunt.registerTask('default', ['bowercopy', 'watch']);

};