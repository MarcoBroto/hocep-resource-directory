
Vue.config.devtools = true; // Vue chrome debugger line, remove in deployment

import Multiselect from 'vue-multiselect';
import Resource from '../js/Resource.js';
import Category from '../js/Category.js';
import Service from '../js/Service.js';
import Contact from '../js/Contact.js';
import { sendSearchRequest } from '../js/search.js';
import { fetchOptionsList } from '../js/fetchMultiselectOptions.js';

// Dummy Data (delete when connected to database)
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




let app = new Vue({
	el: '#resource-table-app',
	components: {
		Multiselect: window.VueMultiselect.default,
	},
	data: {
		welcome: true,
		isLoading: false,
		resourceSelectList: [],
		categorySelectList: [],
		serviceSelectList: [],
		zipcodeSelectList: [],
		selectedResource: [],
		selectedService: [],
		selectedCategory: [],
		selectedZipcode: [],
		insuranceRequired: false,
		resources: [],
	},
	methods: {
		csv_tagId(selectedArray) {
			var id_csv_string = selectedArray.map(function(elem){ return elem.id; }).join();
			return id_csv_string;
		},
		csv_zipcode(selectedArray) {
			var id_csv_string = selectedArray.join();
			return id_csv_string;
		},
		getSelectorParams() {
			var params = {};
			if (this.resourceIsSelected) {
				params['resource'] = this.csv_tagId(this.selectedResource);
			}
			else {
				if (this.selectedCategory.length)
					params['category'] = this.csv_tagId(this.selectedCategory);
				if (this.selectedService.length)
					params['service'] = this.csv_tagId(this.selectedService);
				if (this.selectedZipcode.length)
					params['zipcode'] = this.csv_zipcode(this.selectedZipcode);
			}
			params['insurance'] = this.insuranceRequired;
			return params;
		},
		search() {
			this.welcome = false;
			this.isLoading = true;
			let params = this.getSelectorParams();
			sendSearchRequest(params, this);
		},
	},
	computed: {
		resourceIsSelected() {
			return this.selectedResource.length;
		},
		isLoad() {
			return this.isLoading;
		},
	}
});


fetchOptionsList('resource', app, 'resourceSelectList');
fetchOptionsList('category', app, 'categorySelectList');
fetchOptionsList('service', app, 'serviceSelectList');
fetchOptionsList('zipcode', app, 'zipcodeSelectList');

