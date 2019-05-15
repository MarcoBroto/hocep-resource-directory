
const request = require('ajax-request');
import Resource from '../js/Resource.js';
import Contact from '../js/Contact.js';
import Tag from '../js/Tag.js';

export function createResource(resource_data) {
	request({url: '../php/createResource.php', data: {'resource': resource_data}, method: 'POST'}, function(err, response, body) {
		if (err) {
			console.log("CREATE RESOURCE REQUEST ERROR");
			return;
		}
		console.log(body);
		try {
			body = JSON.parse(body);
			if (body.response) {
				console.log('Added Resource Successfully.');
				// TODO: refresh edit page interface items
			}
			else
				console.log('Failed to Create Resource.');
		} catch(err) {
			console.log(err);
		}
	});
}

export function updateResource(resource_data) {
	request({url: '../php/updateResource.php', data: {'resource': resource_data}, method: 'POST'}, function(err, response, body) {
		if (err) {
			console.log("UPDATE RESOURCE REQUEST ERROR");
			return;
		}
		console.log(body);
		try {
			if (body.response) {
				console.log('Updated Resource Successfully.');
				// TODO: refresh edit page interface items
			}
			else
				console.log('Failed to Update Resource.');
		} catch(err) {
			console.log(err);
		}
	});
}

export function deleteResource(resource_id) {
	request({url: '../php/deleteResource.php', data: {'id': resource_id}, method: 'POST'}, function(err, response, body) {
		if (err) {
			console.log("DELETE RESOURCE REQUEST ERROR");
			return;
		}
		console.log(body);
		try {
			body = JSON.parse(body);
			if (body.response) {
				console.log('Deleted Resource Successfully.');
				// TODO: refresh edit page interface items
			}
			else
				console.log('Failed to Delete Resource.');
		} catch(err) {
			console.log(err);
		}
	});
}

/*********************************************************/

export function createTag(tag_type, tag_data) {
	if (tag_type !== 'category' && tag_type !== 'service') {
		console.log("Create Tag Failed: Invalid Tag Type")
	}
	request({url: '../php/createTag.php', data: {'type': tag_type, 'tag': tag_data}, method: 'POST'}, function(err, response, body) {
		if (err) {
			console.log("CREATE TAG REQUEST ERROR");
			return;
		}
		console.log(body);
		try {
			body = JSON.parse(body);
			if (body.response) {
				console.log('Added Tag Successfully.');
				// TODO: refresh edit page interface items
			}
			else
				console.log('Failed to Create Tag.');
		} catch(err) {
			console.log(err);
		}
	});
}

export function updateTag(tag_type, tag_data) {
	if (tag_type !== 'category' && tag_type !== 'service') {
		console.log("Update Tag Failed: Invalid Tag Type")
	}
	request({url: '../php/updateTag.php', data: {'type': tag_type, 'tag': tag_data}, method: 'POST'}, function(err, response, body) {
		if (err) {
			console.log("UPDATE TAG REQUEST ERROR");
			return;
		}
		console.log(body);
		try {
			body = JSON.parse(body);
			if (body.response) {
				console.log('Updated Tag Successfully.');
				// TODO: refresh edit page interface items
			}
			else
				console.log('Failed to Update Tag.');
		} catch(err) {
			console.log(err);
		}
	});
}

export function deleteTag(tag_type, tag_id) {
	if (tag_type != 'category' && tag_type != 'service') {
		console.log("Delete Tag Failed: Invalid Tag Type");
		return;
	}
	request({url: '../php/deleteTag.php', data: {'type': tag_type, 'id': tag_id}, method: 'POST'}, function(err, response, body) {
		if (err) {
			console.log("DELETE TAG REQUEST ERROR");
			return;
		}
		console.log(body);
		try {
			body = JSON.parse(body);
			if (body.response) {
				console.log('Deleted Tag Successfully.');
				// TODO: refresh edit page interface items
			}
			else
				console.log('Failed to Delete Tag.');
		} catch(err) {
			console.log(err);
		}
	});
}


export function refreshResources(vueComponent) {
	request({url: '../php/getResourceList.php', data: {}, method: 'GET'}, function(err, res, body) {
		if (err) {
			console.log(err);
			console.log(`Error loading resource list.`);
		}
		else {
			// console.log(body);
			try {
				body = JSON.parse(body);
				// console.log(body);
				if (body.response) {
					body.resources = body.resources.map(x => Object.assign(new Resource, x));
					for (var i = 0; i < body.resources.length; i++) {
						let r = body.resources[i];
						r.services = (r.services) ? JSON.parse(r.services) : [];
						r.categories = (r.categories) ? JSON.parse(r.categories) : [];
						r.contactList = (r.contact_list) ? JSON.parse(r.contactList): [];
						r.insurance = (r.insurance == '1');
						for (var j = 0; j < r.contactList.length; j++)
							r.contactList[j] = Object.assign(new Contact(), r.contactList[j]);
						r.lastUpdate = new Date(r.lastUpdate);
					}
					vueComponent._data['resources'] = body.resources;
				} else
					console.log(`Error loading resource list.`);
			} catch(err) {
				console.log(err);
			}
		}
	});
}

export function refreshTags(tag_type=null, vueComponent) {
	if (tag_type !== 'category' && tag_type !== 'service') {
		console.log(`Invalid tag type. Failed to load list.`);
		return;
	}
	request({url: '../php/getTagList.php', data: {'type': tag_type}, method: 'GET'}, function(err, res, body) {
		if (err) {
			console.log(err);
			console.log(`Error loading ${tag_type} list.`);
		}
		else {
			// console.log(body);
			try {
				body = JSON.parse(body);
				// console.log(body);

				if (body.response) {
					body.tags = body.tags.map(x => Object.assign(new Tag(), x));
					for (var i = 0; i < body.tags.length; i++)
						body.tags[i].id = body.tags[i][`${tag_type}_id`];
					if (tag_type === 'category') {
						//vueComponent.$set()
						vueComponent._data['categories'] = body['tags'];
					} else {
						vueComponent._data['services'] = body['tags'];
					}
				} else
					console.log(`Error loading ${tag_type} list.`);
			} catch(err) {
				console.log(err);
			}
		}
	});
}
