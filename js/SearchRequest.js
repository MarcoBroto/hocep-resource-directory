
/*  */
(function setFilterOptions() { // Fetch db filter options and set clickable filter options in html
	let children = app.$children;
	for (var i = 0; i < children.length; i++) {
		// Send 'select *' query for each filter name
	}
})();


/*  */
function getFilterValues() {
	var filter_json;
	let children = app.$children;

	let filter_name = children[0].$data.value; // Main search-bar filter for resource name
	// console.log(filter_name);
	if (filter_name != null) { // If this filter is in use, the rest are ignored
		filter_json = {'org_name': filter_name }
	}
	else {
		let filter_service = children[1].$data.value;
		let filter_keywords = children[2].$data.value;
		let filter_zipcode = children[3].$data.value;

		filter_json = {
			'service': filter_service,
			'keywords': filter_keywords,
			'zipcode': filter_zipcode,
		};
	}
	console.log(filter_json);
	return filter_json;
}


/*  */
function fulfillRequest(url, params={}, callback) { // Query database for Resource table information for
    $.ajax({url: url, data: params, success: function(result) {
    	//$('#test').html(result); // test line
    	if (callback) callback(result);
    	else {
    		$('#error-message').html(result);
    		console.log("Callback Error");
    	}
  	}});
}


/*  */
function sendFilterQuery() {
    app.$data['disable'] = true; // Disable search button
	tableApp.$data['isLoading'] = true; // Display loading image
	tableApp.$data['isVisible'] = false;
	fulfillRequest('search.php', {}, callback=function(data) {
		// console.log(data);
		data = JSON.parse(data);
		let orgs = [];
		for (var i = 0; i < data.length; i++) { // Convert JSON to Organization objects
			orgs.push(Object.assign(new Organization, data[i]));
			orgs[i].lastUpdate_date = new Date(orgs[i].lastUpdate_date);
		}
		console.log(orgs);

		/* Set vue data */
		tableApp.$data['isLoading'] = false; // Hide loading image
		tableApp.$data['isVisible'] = true; // Display table view
		tableApp.$data['orgs'] = orgs; // Set table row data object to json values
		app.$data['disable'] = false; // Enable search button again
	});
}

