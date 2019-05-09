
const request = require('ajax-request');

export function createResource(resource_data) {
	request({url: '../php/createResource.php', method: 'POST', data: {'resource': resource_data}, json: true}, function(err, response, body) {
		if (err) {
			console.log("CREATE RESOURCE REQUEST ERROR");
			return;
		}
		console.log(body);
		if (body.response) {
			console.log('Added Resource Successfully.');
			// TODO: refresh edit page interface items
		}
		else
			console.log('Failed to Create Resource.');
	});
}

export function updateResource(resource_data) {
	request({url: '../php/updateResource.php', method: 'POST', data: {'resource': resource_data}, json: true}, function(err, response, body) {
		if (err) {
			console.log("UPDATE RESOURCE REQUEST ERROR");
			return;
		}
		console.log(body);
		if (body.response) {
			console.log('Updated Resource Successfully.');
			// TODO: refresh edit page interface items
		}
		else
			console.log('Failed to Update Resource.');
	});
}

export function deleteResource(resource_id) {
	request({url: '../php/deleteResource.php', method: 'POST', data: {'id': resource_id}, json: true}, function(err, response, body) {
		if (err) {
			console.log("DELETE RESOURCE REQUEST ERROR");
			return;
		}
		console.log(body);
		if (body.response) {
			console.log('Deleted Resource Successfully.');
			// TODO: refresh edit page interface items
		}
		else
			console.log('Failed to Delete Resource.');
	});
}

/*********************************************************/

export function createTag(tag_type, tag_data) {
	if (tag_type !== 'category' && tag_type !== 'service') {
		console.log("Create Tag Failed: Invalid Tag Type")
	}
	request({url: '../php/createTag.php', method: 'POST', data: {'type': tag_type, 'tag': tag_data}, json: true}, function(err, response, body) {
		if (err) {
			console.log("CREATE TAG REQUEST ERROR");
			return;
		}
		console.log(body);
		if (body.response) {
			console.log('Added Tag Successfully.');
			// TODO: refresh edit page interface items
		}
		else
			console.log('Failed to Create Tag.');
	});
}

export function updateTag(tag_type, tag_data) {
	if (tag_type !== 'category' && tag_type !== 'service') {
		console.log("Update Tag Failed: Invalid Tag Type")
	}
	request({url: '../php/updateTag.php', method: 'POST', data: {'type': tag_type, 'tag': tag_data}, json: true}, function(err, response, body) {
		if (err) {
			console.log("UPDATE TAG REQUEST ERROR");
			return;
		}
		console.log(body);
		if (body.response) {
			console.log('Updated Tag Successfully.');
			// TODO: refresh edit page interface items
		}
		else
			console.log('Failed to Update Tag.');
	});
}

export function deleteTag(tag_type, tag_id) {
	if (tag_type != 'category' || tag_type != 'service') {
		console.log("Delete Tag Failed: Invalid Tag Type")
	}
	request({url: '../php/deleteTag.php', method: 'POST', data: {'type': tag_type, 'id': tag_id}, json: true}, function(err, response, body) {
		if (err) {
			console.log("DELETE TAG REQUEST ERROR");
			return;
		}
		console.log(body);
		if (body.response) {
			console.log('Deleted Tag Successfully.');
			// TODO: refresh edit page interface items
		}
		else
			console.log('Failed to Delete Tag.');
	});
}
