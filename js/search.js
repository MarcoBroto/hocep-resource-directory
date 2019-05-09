
const request = require('ajax-request');
import Resource from '../js/Resource.js';
import Contact from '../js/Contact.js';

export function sendSearchRequest(params, component) {
	console.log('Searching...');
	request({url: '../php/search.php', data: params, method: 'GET', json: true}, function(err, res, body) {
		if (err) {
			console.log(err);
			return;
		}
		console.log(body.resources);
		console.log(body.query);
		if (body.response && component) {
			let new_resources = [];
			for (var i = 0; i < body.resources.length; i++) {
				// Fix non-uniform values
				body.resources[i].categories = JSON.parse(body.resources[i].categories);
				body.resources[i].services = JSON.parse(body.resources[i].services);
				body.resources[i].contactList = JSON.parse(body.resources[i].contactList);
				body.resources[i].lastUpdate = new Date(body.resources[i].lastUpdate);
				body.resources[i].insurance = (body.resources[i].insurance == '1');
				for (var j = 0; j < body.resources[i].contactList.length; j++)
					body.resources[i].contactList[j] = Object.assign(new Contact(), body.resources[i].contactList[j]);
				
				let newResource = Object.assign(new Resource(), body.resources[i]);
				new_resources.push(newResource);
			}
			component._data.resources = new_resources;
			component._data.isLoading = false;
		}
	});
}
