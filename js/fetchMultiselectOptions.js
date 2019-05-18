
const request = require('ajax-request');
const path = require('path');

const FILEPATH = path.resolve(__dirname, '/php/fetchOptions.php');

/**
 * Query database for desired list of element names and assign the values to the selected Vue data field.
 *	list 		 <- Name of list to fetch from database
 *	vueComponent <- Reference to the Vue component that holds the desired data field.
 *	dataField 	 <- Vue componenet data field that the values should be assigned to.
 */
export function fetchOptionsList(list, vueComponent, dataField) {
	request({url: `${FILEPATH}`, data: {'options': list}, method: 'GET'}, function(err, res, body) {
		if (err) {
			console.log(err);
			console.log(`Error fetching \"${list}\".`);
		}
		//console.log(body);
		try {
			let data = JSON.parse(body);
			//console.log(data);
			if (data.response) {
				switch(list) {
					case 'resource':
						if (data[list] != null)
							vueComponent.$data[dataField] = data[list];
							break;
					case 'category':
						if (data[list] != null)
							vueComponent.$data[dataField] = data[list];
							break;
					case 'service':
						if (data[list] != null)
							vueComponent.$data[dataField] = data[list];
							break;
					case 'zipcode':
						if (data[list] != null) {
							let zipcodes = data[list].map(ind => ind.zipcode);
							vueComponent.$data[dataField] = zipcodes;
						}
							break;
					default:
						console.log(`Error fetching \"${list}\".`);
				}
			} else
				console.log(`Error fetching \"${list}\".`);
		} catch (err) {
			console.log(err);
			return;
		}	
	});
}
