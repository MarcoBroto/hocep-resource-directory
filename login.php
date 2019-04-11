<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" href="css/standard.css">
	<link rel="stylesheet" href="css/login.css">
	<!--  Javascript APIs from CDN  -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
</head>
<body>

<!-- Header Area -->
<div id="header" class="header header-size standard-colors">
	<a class="link-text header-size" href="#"><img name="logo-header" src="assets/logo.png"></a>
</div>

<!-- Login Area -->
<div id="login-area">
<h1>Resource Administration Login</h1>

<div id="login-form">
<!-- <div class="center" v-if="failed">
	<h2>Username or Password is Incorrect</h2>
</div> -->
<form name="login" action="php/checkLogin.php" method="POST">
    <!-- Username: -->
    <img class="center" src="assets/sharp-account_box-24px.svg">
    <input name="username" type="text" placeholder="Username" maxlength="20" required autofocus><br>
    <!-- Password: -->
    <img class="center" src="assets/sharp-fingerprint-24px.svg">
    <input name="password" type="password" placeholder="Password" required><br>
    <input class="submit" type="submit" value="Login">
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script>
	Vue.config.devtools = true; // Vue chrome debugger line, remove in deployment

	let app = new Vue({
		el: 'login-area',
		data: {
			failed: false,
		},
	});

	function fulfillRequest(url, params={}, callback) {
	    $.ajax({url: url, 
	    		data: params, 
	    		success: function(result) {
	    	/* Begin function code */
	    	//$('#test').html(result); // test line
	    	if (callback) callback(result);
	    	else {
	    		$('#error-message').html(result);
	    		console.log("Callback Error");
	    	}
	  	}});
	}

	function checkLogin() {
		let login = {
			uname: $("form[name='username']"),
			password: $("form[name='password']")
		}

		fulfillRequest('checkLogin.php', params={}, callback=function(data) {
			
		});
	}
</script>

</div>

<!-- Footer Area -->
<div id="footer" class="footer footer-size standard-colors">
	<div class="footer-quicklinks footer-size">
		<ul class="footer-quicklinks-items footer-size">
			<li class="footer-quicklinks-item"><a href="https://homelessopportunitycenter.org">Home</a></li>
			<li class="footer-quicklinks-item"><a href="index.php">Resources</a></li>
		</ul>
	</div>
</div>

</body>
</html>