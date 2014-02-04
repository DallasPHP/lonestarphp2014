module.exports = function (grunt) {
    grunt.initConfig({
        autoprefixer: {
            dist: {
                files: {
                    'public/css/style.min.css': 'public/css/style.min.css'
                }
             }
        },
        sass: {
            dist: {
                options: {
                    style: 'compressed'
                },
                files: {
                    'public/css/style.min.css': 'public/css/style.scss'
                }
            }
        },
        watch: {
            scss: {
                files: ['public/css/*.scss', 'public/css/**/*.scss'],
                tasks: ['sass'],
                options: {
                    spawn: false
                }
            },
            css: {
                files: ['public/css/style.min.css'],
                tasks: ['autoprefixer']
            }
        }
    });

    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');

    grunt.registerTask('default', ['sass', 'autoprefixer']);
};
