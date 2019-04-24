
function sendRequest(url, params={}, callback) { // Query database for Resource table information for
    $.ajax({url: url, data: params, success: function(result) {
    	//$('#test').html(result); // test line
    	if (callback) callback(result);
    	else {
    		$('#error-message').html(result);
    		console.log("Callback Error");
    	}
  	}});
}

function handleErrors() { }
function parseJSON(json) { }
