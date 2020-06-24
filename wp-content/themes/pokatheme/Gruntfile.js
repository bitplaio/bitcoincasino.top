module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			dist: {
				files: {
					'css/styles.css' : 'scss/styles.scss'
				}
			}
        },
        cssmin: {
			dist: {
				files: {
					'css/styles-vendor.min.css': 'css/styles-vendor.css'
				}
			}
        },
        uglify: {
            options: {
              mangle: false
            },
            my_target: {
              files: {
                'js/scripts.all.min.js': ['js/plugins.js', 'js/main.js']
              }
            }
        },
		watch: {
			css: {
				files: '**/*.scss',
				tasks: ['sass'],
                options: {
                    livereload: true,
                },
			},
            php: {
                files: ['**/*.php'],
                options: {
                    livereload: true,
                }
            }
		}
	});
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.registerTask('default',['watch']);
}
