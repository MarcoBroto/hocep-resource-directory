<?php
	// if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
	//     header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
	//     die( header( 'Location: /login' ) );
	// }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Resource Editor</title>

	<!-- Bootstrap with Flatly Theme import -->
	<link href="bootstrap/flatly.bootstrap.min.css" rel="stylesheet">
	<!-- Used for multi-select dropdown menu -->
	<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
	<!-- Page Stylesheet -->
	<link href="css/style.edit.css" rel="stylesheet">

	<!-- Bootstrap JS imports -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!-- VueJS import -->
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mt-0 mb-4">
	<a class="navbar-brand" href="/edit.html"><h4>Admin Dashboard | <span class="text-secondary">Resource Editor</span></h4></a>
	<div class="ml-auto">
		<a class="text-white disabled mr-3">User: <? /* echo current user */echo 'mrsoto3' ?></a>
		<button class="btn btn-secondary">Logout</button>
	</div>
</nav>

<div id="resource-editor" class="container">
	<ul class="nav nav-dark nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#resources"><h4 class="text-primary">Resources
			<span class="badge badge-danger badge-pill">{{ resources.length }}</span></h4></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#categories"><h4 class="text-primary">Categories
			<span class="badge badge-success badge-pill">{{ categories.length }}</span></h4></a>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="tab" href="#services"><h4 class="text-primary">Services
			<span class="badge badge-warning badge-pill">{{ services.length }}</span></h4></a>
		</li>
	</ul>

	<div id="tab-content" class="tab-content overflow-auto">
		<div class="tab-pane fade active show" id="resources">
			<table class="table table-hover">
				<thead>
					<tr class="mx-0 my-0">
						<th colspan="6" class="center mb-0">
							<button class="btn btn-info" type="button" data-toggle="modal" data-target="#resource-modal" data-backdrop="static" data-keyboard="false" v-on:click="newModalResource()">+ Add Resource</button>
						</th>
					</tr>
					<tr class="table-primary">
						<th scope="col">_id</th>
						<th scope="col">Resource Name</th>
						<th scope="col">Description</th>
						<th scope="col">Last Updated</th>
						<th scope="col">Updated By</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(resource, ind) in resources" class="table-light" :class="{'table-danger': !isUpdated(resource.lastUpdate)}">
						<td>{{ resource.id }}</td>
						<td class="name">{{ resource.name }}</td>
						<td class="description">{{ resource.description }}</td>
						<td>{{ formatDate(resource) }}</td>
						<td>{{ resource.lastUpdate_admin }}</td>
						<td>
							<button v-if="isUpdated(resource.lastUpdate)" class="btn btn-outline-info" data-toggle="modal" data-target="#resource-modal" v-on:click="setModalResource(resource)">View/Edit</button>
							<button v-else class="btn btn-info" data-toggle="modal" data-target="#resource-modal" data-backdrop="static" data-keyboard="false" v-on:click="setModalResource(resource)">View/Edit</button>
						</td>
					</tr>

				</tbody>
			</table>
			<small>* Colored Rows Indicate Resources that have passed the 6 month udpate cutoff. They must be reupdated.</small>
		</div>

		<div class="tab-pane fade" id="categories">
			<table class="table table-hover">
				<thead>
					<tr class="mb-0 pb-0">
						<th colspan="4" class="center">
							<button class="btn btn-success" data-toggle="modal" data-target="#category-modal" data-backdrop="static" data-keyboard="false" v-on:click="newModalCategory()">+ Add Category</button>
						</th>
					</tr>
					<tr class="table-primary mt-0 pt-0">
						<th scope="col">_id</th>
						<th scope="col">Category Name</th>
						<th scope="col">Description</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(category, ind) in categories" class="table-light">
						<td>{{ category.id }}</td>
						<td class="name"><button class="btn btn-success" disabled>{{ category.name }}</button></td>
						<td class="description">{{ category.description }}</td>
						<td><button class="btn btn-outline-info" data-toggle="modal" data-target="#category-modal" data-backdrop="static" data-keyboard="false" v-on:click="setModalCategory(category)">Edit Category</button></td>
					</tr>
				</tbody>
			</table>
			<small>* Deleting a category tag will dissasociate it from all resources linked to it.</small>
		</div>

		<div class="tab-pane fade" id="services">
			<table class="table table-hover">
				<thead>
					<tr class="mb-0 pb-0">
						<th colspan="4" class="center">
							<button class="btn btn-warning" data-toggle="modal" data-target="#service-modal" data-backdrop="static" data-keyboard="false" v-on:click="newModalService()">+ Add Service</button>
						</th>
					</tr>
					<tr class="table-primary">
						<th scope="col">_id</th>
						<th scope="col">Service Name</th>
						<th scope="col" colspan="2">Description</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(service, ind) in services" class="table-light">
						<td>{{ service.id }}</td>
						<td class="name"><button class="btn btn-warning" disabled>{{ service.name }}</button></td>
						<td class="description">{{ service.description }}</td>
						<td><button class="btn btn-outline-info" data-toggle="modal" data-target="#service-modal" data-backdrop="static" data-keyboard="false" v-on:click="setModalService(service)">Edit Service</button></td>
					</tr>
				</tbody>
			</table>
			<small>* Deleting a service tag will dissasociate it from all resources linked to it.</small>
		</div>
	</div>

	<!-- 		Resource Modal Interface			 -->
	<div id="resource-modal" class="modal fade" v-if="modalResource != null" style="overflow-y: scroll;">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content" style="">
				<div class="modal-header">
					<h3 v-if="!isNewElement" class="modal-title"><strong><span class="text-info">{{ modalResource.name }}</span><span class="text-secondary"> - Edit/Update Data</span></strong></h3>
					<h3 v-else class="modal-title"><strong><span class="text-info">Create New Resource</span></strong></h3>
				</div>
				<div class="modal-body">
					<form v-if="modalResource != null" class="container-fluid">
						<div class="row">
							<div class="col col-6">
								<fieldset>
									<legend><label for="">Name</label></legend>
									<div class="form-group">
										<input v-model="modalResource.name" type="form-text" class="form-control" id="" aria-describedby="resource-name" placeholder="Resource or Organization Name" autocomplete="off" required>
										<small class="form-text text-muted">*Required</small>
									</div>

									<div class="row">
										<div class="col col-7">
											<legend><label for="">Address</label></legend>
											<div class="form-group">
												<input v-model="modalResource.street" type="textarea" class="form-control" id="" aria-describedby="address" placeholder="Street Address" autocomplete="off" required>
												<small class="form-text text-muted">*Required</small>
											</div>

										</div>
										<div class="col col-5">
											<legend><label for="">Zipcode</label></legend>
											<div class="form-group">
												<input v-model="modalResource.zipcode" type="number" class="form-control" id="" aria-describedby="zipcode" autocomplete="on" placeholder="ex: 87920" max="99999" min="0" maxlength="5" required>
												<small class="form-text text-muted">*Required</small>
											</div>
										</div>
									</div>

									<legend><label for="">Phone Number</label></legend>
									<div class="form-group">
										<input v-model="modalResource.phone" type="textarea" class="form-control" id="" aria-describedby="phone" placeholder="Phone #" required>
										<small class="form-text text-muted">*Required</small>
									</div>

									<legend><label for="">Website</label></legend>
									<div class="form-group">
										<input v-model="modalResource.website" type="textarea" class="form-control" id="" aria-describedby="website" placeholder="Website URL">
									</div>

									<legend><label for="">Email</label></legend>
									<div class="form-group">
										<input v-model="modalResource.email" type="email" class="form-control" id="" aria-describedby="email" placeholder="Resource Email Address">
									</div>
								</fieldset>
							</div>

							<div class="col col-6">
								<fieldset class="form-group">
									<legend><label for="" class="text-success">Categories</label></legend>
									<div class="form-group">
										<multiselect
											:class="{invalid:true === null}"
											v-model="selectedCategory" 
											:options="categorySelectList"
											placeholder="Select a category this resource belongs to"
											multiple="false"
											optionsLimit="6"
											max="10"
											label="name"
											track-by="name"
											class="category-tag">
											<!-- <template slot="tag" slot-scope="{ option, remove }" class="multiselect__tags">
												<span class="custom__tag">
													<span>{{ option }}</span>
													<span class="custom__remove" @click="remove(option)">❌</span>
												</span>
											</template> -->
											<template slot="clear" slot-scope="props">
												<div class="multiselect__clear" v-if="selectedCategory.length" @mousedown.prevent.stop="clearAll(props.search)"></div>
											</template>
										</multiselect>
									</div>

									<legend><label for="" class="text-warning">Services Provided</label></legend>
									<div class="form-group">
										<multiselect
											v-model="selectedService"
											:options="serviceSelectList"
											placeholder="Select a service this resource provides"
											multiple="true"
											optionsLimit="6"
											max="20"
											name="serviceSelect"
											label="name"
											track-by="name"
											class="service-tag">
										</multiselect>
									</div>
									
									<legend>Other Options</legend>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1" :checked="modalResource.needInsurance">
										<label class="custom-control-label" for="customCheck1">Insurance Required</label>
									</div>
									<hr>

									<legend class="justify-content-between">Contact List <button class="btn btn-sm btn-outline-primary" style="float: right;" type="button" data-toggle="modal" data-target="#contact-modal" v-on:click="newModalContact()">+ Add New Contact</button></legend>
									<div class="overflow-auto">
										<table class="table table-hover">
											<thead>
												<tr class="table-primary">
													<th scope="col">Name</th>
													<th scope="col">Title</th>
													<th scope="col">Phone</th>
													<th scope="col">Email</th>
												</tr>
											</thead>
											<tbody>
												<!-- Vue Component -->
												<tr v-for="(contact, contact_ind) in modalResource.contactList" v-on:click="setModalContact(contact, contact_ind)" class="table-light" data-toggle="modal" data-target="#contact-modal">
													<td class="no-wrap-col">{{ contact.fname }}</td>
													<td class="no-wrap-col">{{ contact.lname }}</td>
													<td class="no-wrap-col">{{ contact.title }}</td>
													<td class="no-wrap-col">{{ contact.phone }}</td>
													<td class="no-wrap-col">{{ contact.email }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</fieldset>
							</div>
						</div>

						<hr/><!-- Horizontal Rule -->
						<div class="row">
							<div class="col col-6">
								<legend><label for="">Description</label></legend>
									<div class="form-group">
										<textarea v-model="modalResource.description" class="form-control" id="" rows="3"></textarea>
										<small class="form-text text-muted">Text will display as it appears.</small>
									</div>

									<legend><label for="">Qualifications and Restrictions</label></legend>
									<div class="form-group">
										<textarea v-model="modalResource.requirements" class="form-control" id="" rows="3"></textarea>
										<small class="form-text text-muted">Text will display as it appears.</small>
									</div>
							</div>

							<div class="col col-6">
								<legend><label for="">Required Documents</label></legend>
								<div class="form-group">
									<textarea v-model="modalResource.documents" class="form-control" id="" rows="3"></textarea>
									<small class="form-text text-muted">Text will display as it appears.</small>
								</div>

								<legend><label for="">Hours of Operation</label></legend>
								<div class="form-group">
									<textarea v-model="modalResource.opHours" class="form-control" id="" rows="3"></textarea>
									<small class="form-text text-muted">Text will display as it appears.</small>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button v-if="!isNewElement" class="btn btn-sm btn-outline-danger mr-auto" data-toggle="modal" data-target="#warning-modal" type="button">Delete Document</button>
					<button v-on:click="submit_createResource()" class="btn btn-info" data-dismiss="modal" type="button" :disabled="!isValidResource">{{ (isNewElement) ? 'Create Resource' : 'Update Document' }}</button>
					<button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- 		Category Modal	 -->
	<div id="category-modal" class="modal fade" v-if="modalCategory != null">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content" style="">
				<div class="modal-header">
					<h3 v-if="!isNewElement" class="modal-title"><strong><span class="text-success">{{ modalCategory.name }}</span><span class="text-secondary"> - Edit Category</span></strong></h3>
					<h3 v-else class="modal-title"><strong><span class="text-success">New Category</span></strong></h3>
				</div>
				<div class="modal-body">
					<form class="container-fluid">
						<fieldset>
							<legend><label for="">Name</label></legend>
							<div class="form-group">
								<input v-model="modalCategory.name" type="textarea" autocomplete="off" class="form-control" id="" aria-describedby="resource-name" placeholder="Enter the Category Name" required>
								<small class="form-text text-muted">*Required</small>
							</div>

							<legend><label for="">Description</label></legend>
							<div class="form-group">
								<textarea v-model="modalCategory.description" class="form-control" id="" aria-describedby="description" placeholder="Write a description of the category..." required rows="3"></textarea>
							</div>
						</fieldset>
					</form>
				</div>

				<div class="modal-footer">
					<button v-if="!isNewElement" class="btn btn-outline-danger mr-auto" type="button">Delete</button>
					<button class="btn btn-info" type="button">{{ (isNewElement) ? 'Create' : 'Update' }}</button>
					<button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- 		Service Modal		 -->
	<div id="service-modal" class="modal fade" v-if="modalService != null">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content" style="">
				<div class="modal-header">
					<h3 v-if="!isNewElement" class="modal-title"><strong><span class="text-warning">{{ modalService.name }}</span><span class="text-secondary"> - Edit Service</span></strong></h3>
					<h3 v-else class="modal-title"><strong><span class="text-warning">New Category</span></strong></h3>

				</div>
				<div class="modal-body">
					<form class="container-fluid">
						<fieldset>
							<legend><label for="">Name</label></legend>
							<div class="form-group">
								<input v-model="modalService.name" type="textarea" autocomplete="off" class="form-control" id="" aria-describedby="resource-name" placeholder="Enter the Service Name" required>
								<small class="form-text text-muted">*Required</small>
							</div>

							<legend><label for="">Description</label></legend>
							<div class="form-group">
								<textarea v-model="modalService.description" class="form-control" id="" aria-describedby="description" placeholder="Write a description of the service..." rows="3"></textarea>
							</div>
						</fieldset>
					</form>
				</div>

				<div class="modal-footer">
					<button v-if="!isNewElement" class="btn btn-outline-danger mr-auto" type="button">Delete</button>
					<button class="btn btn-info" type="button">{{ (isNewElement) ? 'Create' : 'Update' }}</button>
					<button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- 		Contact Modal    -->
	<div id="contact-modal" class="modal fade" v-if="modalContact != null">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content" style="">
				<div class="modal-header">
					<h3 v-if="modalResource != null" class="modal-title"><strong>{{ (isNewContact) ? 'Add New Contact' : 'Edit Contact' }} for {{ (isNewElement) ? 'a ' : '' }}<span class="text-info">{{ (!isNewElement) ? modalResource.name : 'New Resource' }}</span></strong></h3>
				</div>
				<div class="modal-body">
					<form class="container-fluid">
						<fieldset>
							<legend><label for="">First Name</label></legend>
							<div class="form-group">
								<input v-model="modalContact.fname" type="textarea" autocomplete="off" class="form-control" aria-describedby="first-name" placeholder="Contact First Name" required>
								<small class="form-text text-muted">*Required</small>
							</div>
							<legend><label for="">Last Name</label></legend>
							<div class="form-group">
								<input v-model="modalContact.lname" type="textarea" autocomplete="off" class="form-control" aria-describedby="last-name" placeholder="Contact Last Name" required>
								<small class="form-text text-muted">*Required</small>
							</div>
							<legend><label for="">Title</label></legend>
							<div class="form-group">
								<input v-model="modalContact.title" class="form-control" type="text-area" aria-describedby="title" placeholder="Contact Title/Position" rows="3"></input>
							</div>
							<legend><label for="">Phone</label></legend>
							<div class="form-group">
								<input v-model="modalContact.phone" class="form-control" type="text-area" aria-describedby="phone" placeholder="Contact Phone #" rows="3"></input>
								<small class="form-text text-muted">*Required</small>
							</div>
							<legend><label for="">Email</label></legend>
							<div class="form-group">
								<input v-model="modalContact.email" class="form-control" type="email" aria-describedby="email" placeholder="Contact Email Address" rows="3"></input>
							</div>
						</fieldset>
					</form>
				</div>

				<div class="modal-footer">
					<button v-if="!isNewContact" v-on:click="removeContact(contactInd)" data-dismiss="modal" class="btn btn-outline-danger mr-auto" type="button">Remove</button>
					<button class="btn btn-info" v-on:click="(isNewContact) ? addContact() : updateContact(contactInd)" data-dismiss="modal" type="button">{{ (isNewContact) ? 'Add' : 'Update' }}</button>
					<button v-on:click="resetContact()" class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<div id="warning-modal" class="modal fade">
		<div class="modal-dialog modal-dialog-centered" style="max-width: 20rem;">
			<div class="modal-content bg-danger">
				<div class="modal-body">
					<h3>Warning</h3>
					<h5>Are you sure you want to delete this? This action cannot be undone and all data will be lost.</h5>
					<button onclick="jquery_deleteResource()" v-on:click="submit_deleteResource()" class="btn btn-outline-primary" data-dismiss="modal" type="button">Delete</button>
					<button class="btn btn-secondary" data-dismiss="modal" type="button" style="float: right;">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="../dist/bundle.edit.min.js"></script>
<script src="../js/editorJQuery.js"></script>

</body>
</html>