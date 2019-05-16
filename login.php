<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

	<!-- Bootstrap with Flatly Theme import -->
	<link href="bootstrap/flatly.bootstrap.min.css" rel="stylesheet">
	<!-- Page Stylesheet -->
	<!-- <link href="css/style.login.css" rel="stylesheet"> -->

	<!-- JQuery Imports -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<!-- Bootstrap JS Imports -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!-- VueJS import -->
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mt-0 mb-4">
	<h4 class="text-light"><span class="text-light">Admin Dashboard | </span><span class="text-secondary">Login</span></h4>
</nav>

<div id="login-app" class="container jumbotron my-4">
	<div  style="text-align: center;">
		<h1 class="display-3">Opportunity Center</h1>
		<h3>Resource Directory Editor Login</h3>
	</div>
	<hr/>
	<div class="container" style="width: 45vw;">
         <form id="login-form" action="php/checkLogin.php" method="POST" >
        <fieldset>
				<legend><label>Username</label></legend>
				<input v-if="failed" type="form-text" class="form-control form-control-lg is-invalid" name="username" aria-describedby="username" required>
				<input v-else type="form-text" class="form-control form-control-lg" name="username" aria-describedby="username" required>
	      		<small id="usernameHelp" class="form-text text-muted"></small>

				<legend><label>Password</label></legend>
				<input v-if="failed" type="password" class="form-control form-control-lg is-invalid" name="password" aria-describedby="password" required>
				<input v-else type="password" class="form-control form-control-lg" name="password" aria-describedby="password" required>
				<small id="passwordHelp" class="form-text text-muted"></small>
			</fieldset>
			<div v-if="failed" class="alert alert-dismissible alert-danger mt-3">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Invalid Username or Password.</strong> Change a few things up and try submitting again.
			</div>
            <div class="mt-3" style="text-align: center;">
                <button class="btn btn-lg btn-primary" style="width: 7.5rem;">Login</button>
            </div>
		</form>
		
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="./vue/LoginVue.js" type="text/javascript"></script>

</body>
</html>