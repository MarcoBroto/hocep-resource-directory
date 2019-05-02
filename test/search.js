
services = null;
resource = "1";

function sendSearchRequest(params) {
	console.log('Searching...');
	$.ajax({url: '../php/search.php', data: params, type: 'GET', success: function(response) {
		console.log(response);
	}});
}
