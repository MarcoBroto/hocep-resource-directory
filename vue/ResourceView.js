
Vue.component("ResourceView", {
	props: {
		resource: {
			type: Object,
			required: true
		},
		ind: {
			type: Number,
			required: true,
		},
	},
	data() {
		return {
			isOpen: false,
		}
	},
	methods: {
		formatDate(date) {
			return `${date.getMonth()}/${date.getDate()}/${date.getFullYear()}`;
		},
		toggleOpen() {
			this.isOpen = !this.isOpen;
		}
	},
	computed: {
		isUpdated: function() {
			let today = new Date();
			if (today.getFullYear() > this.resource.lastUpdate.getFullYear() || (today.getMonth()-this.resource.lastUpdate.getMonth()) > 6)
				return false;
			return true;
		}
	},
	template: `
		<div class="bg-secondary rounded my-3">
			<div class="row px-4 pt-2" :class="{'pb-2': !isOpen}">
				<div class="col-sm-5 px-0">
					<div class="card bg-primary mr-1 my-1 data-card-top">
						<div class="card-body py-2">
							<h4 class="card-title text-white">Name<button style="float: right;"class="btn btn-sm btn-info ml-auto pl-auto" data-toggle="collapse" :data-target="'#collapse' + ind" v-on:click="toggleOpen()">
								<span v-if="!isOpen">Show More<img src="./assets/outline-expand_more-24px.svg"></span>
								<span v-else>Show Less<img src="./assets/baseline-expand_less-24px.svg"></span>
							</button></h4>
							<h5 class="card-text text-info overflow"><strong>{{ resource.name }}</strong></h5>
						</div>
					</div>
					<div class="card bg-light mr-1 my-1 data-card-top">
						<div class="card-body py-2 overflow-auto">
							<h4 class="card-title">Address</h4>
							<h5 class="card-text overflow">{{ resource.getAddress() }}</h5>
						</div>
					</div>
					<div class="card bg-light mr-1 data-card-top">
						<div class="card-body py-2">
							<h4 class="card-title">Website</h4>
							<div class="overflow-auto">
							<h5 class="card-text overflow"><a :href="'http://' + resource.website" target="_blank" class="text-primary">{{ resource.website }}</a></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4 px-0">
					<div class="card mr-1 my-1 data-card-top" :class="{'bg-danger': !isUpdated, 'bg-success': isUpdated}">
						<div class="card-body py-2">
							<h4 class="card-title text-white">Up To Date?</h4>
							<h5 class="card-text overflow d-flex text-white"><span class="justify-content-between">{{ (isUpdated) ? 'Yes': 'No' }}</span><span class="ml-auto pl-auto badge badge-dark">Last Updated: {{ formatDate(resource.lastUpdate) }}</span></h5>
						</div>
					</div>
					<div class="card bg-light mr-1 my-1 data-card-top">
						<div class="card-body py-2">
							<h4 class="card-title">Phone</h4>
							<h5 class="card-text overflow">{{ resource.phone }}</h5>
						</div>
					</div>
					<div class="card bg-light mr-1 my-1 data-card-top">
						<div class="card-body py-2">
							<h4 class="card-title">Email</h4>
							<h5 class="card-text overflow"><a :href="'mailto:' + resource.email" class="text-primary">{{ resource.email }}</a></h5>
						</div>
					</div>
				</div>
				<div class="col-sm-3 px-0">
					<div class="card bg-light mr-0 my-1">
						<div class="card-body overflow-auto cat-serv-card">
							<h4 class="card-title"><span class="text-success">Categories</span ></h4>
							<div>
								<span v-for="category in resource.categories" class="badge badge-pill badge-success ml-0 mr-1">{{ category }}</span>
							</div>
							<hr>
							<h4 class="card-title"><span class="text-warning">Services</span></h4>
							<div>
								<span v-for="service in resource.services" class="badge badge-pill badge-warning ml-0 mr-1">{{ service }}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 	Collapsing data row 	-->
			<div :id="'collapse' + ind" class="collapse row px-4 pb-2">
				<div class="col-md-7 mx-0 px-0">
					<div class="card bg-light ml-0 mr-1 my-1">
						<div class="card-body overflow-auto long-text-card">
							<h4 class="card-title">Description</h4>
							<p class="card-text"><span style="white-space:pre">{{ resource.description }}</span></p>
						</div>
					</div>

					<div class="card bg-light ml-0 mr-1 my-1">
						<div class="card-body overflow-auto long-text-card">
							<h4 class="card-title">Qualificatons and Requirements</h4>
							<p class="card-text">
								<span v-if="resource.insurance"><strong class="text-danger">*Insurance is Required</strong><br></span>
								<span style="white-space:pre">{{ resource.requirements }}</span>
							</p>
						</div>
					</div>

					<div class="card bg-light ml-0 mr-1 my-1">
						<div class="card-body overflow-auto long-text-card">
							<h4 class="card-title">Required Documents</h4>
							<p class="card-text"><span style="white-space:pre">{{ resource.documents }}</span></p>
						</div>
					</div>
				</div>
				<div class="col-md-5 mx-0 px-0">
					<div class="card bg-light mx-0 my-1">
						<div class="card-body overflow-auto">
							<h4 class="card-title">Hours of Operation</h4>
							<div>
								<h5>
									<span style="white-space:pre">{{ resource.opHours }}</span><br>
								</h5>
							</div>
						</div>
					</div>
					<div class="card bg-light mx-0 my-1">
						<div class="card-body overflow-auto">
							<h4 class="card-title">Contact List</h4>
							<div v-if="resource.contactList && resource.contactList.length > 0" class="table-border overflow-auto">
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
										<tr v-for="contact in resource.contactList" class="table-light">
											<td class="name-col overflow">{{ contact.fullname() }}</td>
											<td class="title-col overflow">{{ contact.title }}</td>
											<td class="phone-col">{{ contact.phone }}</td>
											<td><a href="http://www.apple.com">{{ contact.email }}</a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	`
})