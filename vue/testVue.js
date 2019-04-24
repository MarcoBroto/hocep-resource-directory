
Vue.config.devtools = true; // Vue chrome debugger line, remove in deployment

var contact1 = new Contact(1, 'Michael Hawk', 'The Dude', '(915) 253-4321', 'micawk@icloud.com');
var contact2 = new Contact(2, 'Michael Hunt', 'The Man', '(915) 253-2331', 'mikunt@gmail.com');
var contact3 = new Contact(3, 'Janet Hanky', 'Jan the Man', '(915) 431-4321', 'janisaman@outlook.com');
let clist = [
	new Category(1, 'Health', 'Resources pertaining to physical health.'),
	new Category(2, 'Shelter', 'Resources that provide housing services or living accomodations'),
	new Category(3, 'Mental Health', 'Resources pertaining to mental health.'),
];
let slist = [
	new Service(2, 'Tutoring', 'Learning resources.'),
	// new Service(3, 'Hitman', 'First rule of fight club. ;)'),
	new Service(4, 'Cleaning', 'Basically'),
	new Service(5, 'Car Repair', 'Repair broken down vehicles.'),
	new Service(6, 'Wedding Planning', 'Planning wedding parties.'),
];
let rlist = [
	new Resource(13, 'Homeless Shelter of El Paso', '6354 Long Street Road', 79932, '(915) 273-7843', 'contact@homelssshelterofelpaso.org', 'www.homelssshelterofelpaso.org', 'Description of homeless shelter of el paso.', '- Requires new id\n- Some more requirements\n', '', false, 'MW 9:00am-4:00pm', [clist[0],clist[1]], slist, new Date(), null, [contact2,contact1,contact3]),

	new Resource(2, 'Shelter Place of El Paso', '6354 Long Street Road', 38293, '(915) 273-7843', 'contact@homelssshelterofelpaso.org', 'www.shelter.org', 'Description of shelter place of el paso.', 'Some more requirements\n- JK just come by', 'Brind a state id.\n Brind a fafsa form.', true, 'MW 9:00am-4:00pm', [clist[0]], [slist[1],slist[3],slist[2]], new Date(), null, [contact1]),

	new Resource(9, 'Homeless Bureau', '532 Street Road', 79932, '(915) 273-7843', 'contact@homelssshelterofelpaso.org', 'www.homelssshelterofelpaso.org', 'Description of homeless bureau of el paso.', '', '', false,'MW 9:00am-4:00pm', [clist[0],clist[1]], [slist[2],slist[1]], new Date(), null, [contact2,contact3]),

	new Resource(783, 'El Paso Dispensary', '7843 Mesa Quemasapplauda Dr', 79983, '(915) 273-7843', 'contact@dispensaryelpaso.com', 'www.epdispense.org', 'Medicinal shop for those in need.', '- Must have a medical id.', 'Documents belong here.', true, 'MW 9:00am-4:00pm', [clist[1],clist[2]], [], new Date(), null, []),
];
rlist[2].lastUpdate.setFullYear(2000);

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
								<span v-if="!isOpen">Show More<img src="assets/outline-expand_more-24px.svg"></span>
								<span v-else>Show Less<img src="assets/baseline-expand_less-24px.svg"></span>
							</button></h4>
							<h5 class="card-text text-info overflow"><strong>{{ resource.name }}</strong></h5>
						</div>
					</div>
					<div class="card bg-light mr-1 my-1 data-card-top">
						<div class="card-body py-2 overflow-auto">
							<h4 class="card-title">Address</h4>
							<h5 class="card-text overflow">{{ resource.address }}</h5>
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
								<span v-for="category in resource.categories" class="badge badge-pill badge-success ml-0 mr-1">{{ category.name }}</span>
							</div>
							<hr>
							<h4 class="card-title"><span class="text-warning">Services</span></h4>
							<div>
								<span v-for="service in resource.services" class="badge badge-pill badge-warning ml-0 mr-1">{{ service.name }}</span>
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
							<p class="card-text">{{ resource.description }}</p>
						</div>
					</div>

					<div class="card bg-light ml-0 mr-1 my-1">
						<div class="card-body overflow-auto long-text-card">
							<h4 class="card-title">Qualificatons and Requirements</h4>
							<p class="card-text">
								<span v-if="resource.needInsurance"><strong class="text-danger">*Insurance is Required</strong><br></span>
								{{ resource.requirements }}
							</p>
						</div>
					</div>

					<div class="card bg-light ml-0 mr-1 my-1">
						<div class="card-body overflow-auto long-text-card">
							<h4 class="card-title">Required Documents</h4>
							<p class="card-text">{{ resource.documents }}</p>
						</div>
					</div>
				</div>
				<div class="col-md-5 mx-0 px-0">
					<div class="card bg-light mx-0 my-1">
						<div class="card-body overflow-auto">
							<h4 class="card-title">Hours of Operation</h4>
							<div>
								<h5>
									{{ resource.opHours }}<br>
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
											<td class="name-col overflow">{{ contact.name }}</td>
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

let app = new Vue({
	el: '#resource-table-app',
	components: {
		Multiselect: window.VueMultiselect.default,
	},
	data: {
		resources: rlist,
		text: [],
		welcome: true,
	},
});
