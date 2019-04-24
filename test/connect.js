
function sendRequest_get(url, params={}, callback) { // Query database for Resource table information for
    $.ajax({type: 'GET', url: url, data: params, success: function(result) {
    	//$('#test').html(result); // test line
    	if (callback) callback(result);
    	else {
    		$('#error-message').html(result);
    		console.log("Callback Error");
    	}
  	}});
}

function sendRequest_post(url, params={}, callback) { // Query database for Resource table information for
    $.ajax({type: 'POST', url: url, data: params, success: function(result) {
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
