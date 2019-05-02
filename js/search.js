
const request = require('ajax-request');

export function sendSearchRequest(params) {
	console.log('Searching...');
	request({url: '../php/search.php', data: params, method: 'GET'}, function(err, res, body) {
		console.log(body);
	});
}
