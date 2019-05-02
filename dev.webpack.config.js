/*
 * This file is the development version of the webpack config file.
 * All changes for development and testing should be implemented and performed here first and deployed
 * on the production config file 'webpack.config.js'.
 * To compile, run 'npm run build-dev' from the command line in the project's home directory.
 */

const path = require('path');

module.exports = {
	mode: 'development',
	node: {
		fs: 'empty',
	},
	entry: {
		main: path.resolve(__dirname, 'js/main.js'),
		edit: path.resolve(__dirname, 'js/edit.js'),
	},
	output: {
		path: path.resolve(__dirname, 'dist'),
		filename: 'bundle.[name].min.js',
	},
	optimization: {
		splitChunks: {
      		chunks: 'all',
    	}
	},
};