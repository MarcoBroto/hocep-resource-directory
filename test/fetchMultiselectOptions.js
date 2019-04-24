
function fetchOptions(list) {
	sendRequest_get('../php/fetchOptions.php', {options: list}, callback=function(response) {
		let data = JSON.parse(response);
		if (data.response) {
			switch(list) {
				case 'resource':
					if (data.resources != null)
						app.$data.resourceNameList = data.resources;
						break;
				case 'category':
					if (data.categories != null)
						app.$data.categoryList = data.categories;
						break;
				case 'service':
					if (data.services != null)
						app.$data.serviceList = data.services;
						break;
				case 'zipcode':
					if (data.zipcodes != null)
						app.$data.zipcodeList = data.zipcodes;
						break;
				default:
					console.log(`Error fetching \"${list}\".`);
			}
		}
		else
			console.log(`Error fetching \"${list}\".`);
	});
}

(function fetchMultiselectOptions() {
	// fetchResourceNames();
	// fetchCategories();
	// fetchServices();
	// fetchZipcodes();

	fetchOptions('resource');
	fetchOptions('category');
	fetchOptions('service');
	fetchOptions('zipcode');
})();
