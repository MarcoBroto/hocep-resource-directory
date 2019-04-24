
function fetchCategories() {
	sendRequest('fetchOptions.php', {options: 'category'}, callback=function(response) {
		let data = JSON.parse(response);
		let resources = [];
	})
}

function fetchServices() {
	sendRequest('fetchOptions.php', {options: 'service'}, callback=function(response) {
		let data = JSON.parse(response);
		let resources = [];
	})
}

function fetchResourceNames() {
	sendRequest('php/fetchOptions.php', {options: ['resource','category']}, callback=function(response) {
		console.log(response);
		let data = JSON.parse(response);
		let resources = [];
		console.log(data);
	})
}

fetchResourceNames();