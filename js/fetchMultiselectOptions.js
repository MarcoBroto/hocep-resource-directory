
const request = require('ajax-request');

/**
 * Query database for desired list of element names and assign the values to the selected Vue data field.
 *	list 		 <- Name of list to fetch from database
 *	vueComponent <- Reference to the Vue component that holds the desired data field.
 *	dataField 	 <- Vue componenet data field that the values should be assigned to.
 */
export function fetchOptionsList(list, vueComponent, dataField) {
	request({url: '../php/fetchOptions.php', data: {'options': list}, method: 'GET', json: true}, function(err, res, body) {
		if (err)
			console.log(err);
		let data = body;
		if (data.response) {
			switch(list) {
				case 'resource':
					if (data.resources != null)
						vueComponent.$data[dataField] = data.resources;
						break;
				case 'category':
					if (data.categories != null)
						vueComponent.$data[dataField] = data.categories;
						break;
				case 'service':
					if (data.services != null)
						vueComponent.$data[dataField] = data.services;
						break;
				case 'zipcode':
					if (data.zipcodes != null)
						vueComponent.$data[dataField] = data.zipcodes;
						break;
				default:
					console.log(`Error fetching \"${list}\".`);
			}
		}
		else
			console.log(`Error fetching \"${list}\".`);
	});
}
