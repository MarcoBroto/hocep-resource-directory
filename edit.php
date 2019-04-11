<?php

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
    die( header( 'Location: login.php' ) );
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Resource Editor</title>
	<link href="css/standard.css" rel="stylesheet">
	<link href="css/edit.css"rel="stylesheet">


</head>

<body>

<!-- Header Area -->
<div id="header" class="header header-size standard-colors">
	<a class="link-text header-size" href="#"><img name="logo-header" src="assets/logo.png"></a>
    <h2 style="color: white">User: <? echo $_GET['uname'] ?></h2>
</div>


<!-- List Area -->
<div id="list-window">
	<div id="orgs-list" class="list-view list-large">
		<button class="btn-add">Add Organization</button>
		<ul>
			<li class="list-item">
				<div class="list-item-label">
				{ org name }
				</div>

				<div class="list-item-btns">
					<button class="btn-list-item">View/Edit</button>
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
			<li class="list-item">
				<div class="list-item-label">
				{ org name }
				</div>

				<div class="list-item-btns">
					<button class="btn-list-item">View/Edit</button>
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
		</ul>
	</div>

	<div id="keywords-list" class="list-view list-small">
		<button class="btn-add">Add Keyword</button>
		<ul>
			<li class="list-item">
				<div class="list-item-label">
				{ keyword }
				</div>

				<div class="list-item-btns">
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
			<li class="list-item">
				<div class="list-item-label">
				{ keyword }
				</div>

				<div class="list-item-btns">
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
			<li class="list-item">
				<div class="list-item-label">
				{ keyword }
				</div>

				<div class="list-item-btns">
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
			<li class="list-item">
				<div class="list-item-label">
				{ keyword }
				</div>

				<div class="list-item-btns">
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
		</ul>
	</div>

	<div id="services-list" class="list-view list-small">
		<button class="btn-add">Add Service</button>
		<ul>
			<li class="list-item">
				<div class="list-item-label">{ Service }</div>

				<div class="list-item-btns">
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
			<li class="list-item">
				<div class="list-item-label">{ Service }</div>

				<div class="list-item-btns">
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
			<li class="list-item">
				<div class="list-item-label">{ Service }</div>

				<div class="list-item-btns">
					<button class="btn-list-item">Delete</button>
				</div>
			</li>
		</ul>
	</div>
</div>

<!-- Footer Area -->
<div id="footer" class="footer footer-size standard-colors">
	<div class="footer-quicklinks footer-size">
		<ul class="footer-quicklinks-items footer-size">
			<li class="footer-quicklinks-item"><a href="https://homelessopportunitycenter.org">Home</a></li>
			<li class="footer-quicklinks-item"><a href="#">Resources</a></li>
			<li class="footer-quicklinks-item"><a href="#">Contact Us</a></li>
		</ul>
	</div>
</div>

</body>
</html>