/*
 * 
 */

const path = require('path');

module.exports = {
	mode: 'production',
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
};