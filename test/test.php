<!DOCTYPE html>
<html>
<head>
	<!-- Bootstrap Import -->
	<link href="../bootstrap/flatly.bootstrap.min.css" rel="stylesheet">
	<!-- Used for multi-select dropdown menu -->
	<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
	<!-- Page Stylesheet -->
	<link href="../css/style.test.css" rel="stylesheet">

	<!-- Bootstrap JS imports -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!-- Vue imports -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
	<!-- <script src="https://unpkg.com/vue-multiselect@2.1.0"></script> -->
	<script>

	</script>

</head>

<body>

<div id="resource-table-app">
	<nav class="navbar navbar-expand-lg bg-primary my-0">
		<a class="navbar-brand" href="/"><img src="../assets/logo.png"></a>
	</nav>

	<div class="container-fluid center bg-light py-3 my-0">
			<h1>El Paso Oppurtunity Center<br>Resource Directory</h1>
			<div class="container center my-3" style="width: 80vw;">
				<legend>Search by Name</legend>
				<div class="row mb-4 bg-secondary px-1 py-1 rounded">
					<multiselect
						v-model="selectedResource"
						:options="resourceSelectList"
						:labelmultiple="false"
						multiple="true"
						optionsLimit="8"
						max="8"
						show-labels="true"
						placeholder="Search for a Resource or Organization by Name"
						label="name"
						track-by="name"
						class="resource-tag">
					</multiselect>
				</div>
				<h5>Or</h5>
				<legend>Filter by Criteria</legend>
				<div class="row mt-3">
					<div class="col col-4 pr-2 pl-0 py-0 rounded">
						<label>Category</label>
						<multiselect
							v-model="selectedCategory" 
							:options="categorySelectList"
							multiple="true"
							placeholder="Filter by Category"
							optionsLimit="2"
							max="5"
							label="name"
							track-by="name"
							class="category-tag">
						</multiselect>
					</div>
					<div class="col col-4 rounded">
						<label>Service</label>
						<multiselect
							v-model="selectedService"
							:options="serviceSelectList"
							multiple="true"
							placeholder="Filter by Services Offered"
							optionsLimit="5"
							max="5"
							label="name"
							track-by="name"
							class="service-tag">
						</multiselect>
					</div>
					<div class="col col-4 pl-2 pr-0 py-0 rounded">
						<label>Zipcode</label>
						<multiselect
							v-model="selectedZipcode"
							:options="zipcodeSelectList"
							multiple="true"
							placeholder="Filter by Zipcode"
							optionsLimit="5"
							max="3"
							class="zipcode-tag">
						</multiselect>
					</div>
				</div>
				<div class="row mt-2 mb-3">
					<legend>Other Options</legend>
					<div class="col-12 custom-control custom-checkbox" style="zoom: 0;">
					<input v-model="insuranceRequired" type="checkbox" class="custom-control-input" id="insuranceCheck" style="">
					<label class="custom-control-label" for="insuranceCheck" style="">Requires Insurance</label>
				</div>
				</div>
			</div>
			<button v-on:click="search()" class="btn btn-lg btn-info" style="font-size: 1.4rem;" ><img src="../assets/baseline-search-24px.svg">Search</button>
	</div>

	<hr>
	<div v-if="isLoading" class="center"><img src="../assets/loading_circle_tic.gif"></div>
	<div v-if="welcome" class="container bg-light center py-4">
		<h2>Welcome to the El Paso Resource Directory for People Experiencing Homelessness</h2><br>
		<h3 style="text-align: left; padding: 1rem 1rem 1rem 1rem;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspThis resource directory is designed to be an ever-evolving guide of services available to people experiencing homelessness in El Paso, Texas. The main goal of the directory is to expand the range of referral services in our community by facilitating interagency collaboration. Feel free to download a copy of this directory for your own records. We appreciate your continued commitment to providing those facing homelessness with the best, culturally competent care.<br><br>DISCLAIMER: Due to the ever-changing nature of programs, organizations, and agencies, no guarantee is given that all information is up-to-date and accurate. The directory is meant to be a guide, so contacting the agencies prior to referral is recommended.</h3>
	</div>
	<div v-else class="container-fluid border-success rounded" style="width: 100%;">
		<h2 class="center">Results</h2>
		<!-- Vue Component -->
		<resource-view v-for="(resource, ind) in resources" :resource="resource" :ind="ind"></resource-view>
		<div class="center">
			<h4 class="text-primary">Your search returned {{ this.resources.length }} results.</h4>
		</div>
	</div>

	<hr>

	<!-- Footer -->
	<footer class="page-footer font-small blue pt-4">
		<!-- Footer Links -->
		<div class="container-fluid text-center text-md-left">
			<!-- Grid row -->
			<div class="row">
				<!-- Grid column -->
				<div class="col-md-6 mt-md-0 mt-3">
					<!-- Content -->
					<h5 class="text-uppercase">Footer Content</h5>
					<p>Here you can use rows and columns here to organize your footer content.</p>
				</div>
				<hr class="clearfix w-100 d-md-none pb-3">
				<!-- Grid column -->
				<div class="col-md-3 mb-md-0 mb-3">
						<!-- Links -->
						<h5 class="text-uppercase">Links</h5>
						<ul class="list-unstyled">
							<li>
								<a href="#!">Link 1</a>
							</li>
							<li>
								<a href="#!">Link 2</a>
							</li>
							<li>
								<a href="#!">Link 3</a>
							</li>
							<li>
								<a href="#!">Link 4</a>
							</li>
						</ul>
					</div>
					<!-- Grid column -->
					<div class="col-md-3 mb-md-0 mb-3">
						<!-- Links -->
						<h5 class="text-uppercase">Links</h5>
						<ul class="list-unstyled">
							<li>
								<a href="#!">Link 1</a>
							</li>
							<li>
								<a href="#!">Link 2</a>
							</li>
							<li>
								<a href="#!">Link 3</a>
							</li>
							<li>
								<a href="#!">Link 4</a>
							</li>
						</ul>
					</div>
			</div>
		</div>
		<!-- Footer Links -->

		<!-- Copyright -->
		<div class="footer-copyright text-center py-3">© 2018 Copyright:
			<a href="https://mdbootstrap.com/education/bootstrap/"> MDBootstrap.com</a>
		</div>
		<!-- Copyright -->

	</footer>
</div>

<script src="Contact.js"></script>
<script src="Category.js"></script>
<script src="Service.js"></script>
<script src="Resource.js"></script>
<script src="connect.js"></script>
<script src="search.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
<script src="../vue/ResourceView.js"></script>
<script src="../vue/testVue.js"></script>
<script src="fetchMultiselectOptions.js"></script>

</body>
</html>