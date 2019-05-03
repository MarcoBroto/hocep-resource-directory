
Vue.config.devtools = true; // Vue chrome debugger line, remove in deployment

import Multiselect from 'vue-multiselect';
import Resource from '../js/Resource.js';
import Category from '../js/Category.js';
import Service from '../js/Service.js';
import Contact from '../js/Contact.js';
import { fetchOptionsList } from '../js/fetchMultiselectOptions.js';
// import * as Editor from '../js/editor.js';


// Dummy Table Data
var contact1 = new Contact(1, 'Michael Hawk', 'The Dude', '(915) 253-4321', 'micawk@icloud.com');
var contact2 = new Contact(2, 'Michael Hunt', 'The Man', '(915) 253-2331', 'mikunt@icloud.com');
var contact3 = new Contact(3, 'Janet Hanky', 'Jan the Man', '(915) 431-4321', 'janisaman@icloud.com');
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
	new Resource(13, 'Homeless Shelter of El Paso', '6354 Long Street Road', 79932, 
		9152737843, 'contact@homelssshelterofelpaso.org', 'www.homelssshelterofelpaso.org', 
		'Description of homeless shelter of el paso.', 
		'- Requires new id\n- Some more requirements\n', '', false,
		'MW 9:00am-4:00pm', [clist[0],clist[1]], [slist[2],slist[5]], new Date(), 'mrsoto3', [contact2,contact1,contact3]),
	new Resource(2, 'Shelter Place of El Paso', '6354 Long Street Road', 38293, 
		9152737843, 'contact@homelssshelterofelpaso.org', 'www.shelter.org', 
		'Description of shelter place of el paso.', 
		'Some more requirements\n- JK just come by', '', true,
		'MW 9:00am-4:00pm', [clist[0]], [slist[1],slist[5],slist[4]], new Date(), 'mrsoto3', [contact1]),
	new Resource(9, 'Homeless Bureau', '532 Street Road', 79932, 
		9152737843, 'contact@homelssshelterofelpaso.org', 'www.homelssshelterofelpaso.org', 
		'Description of homeless bureau of el paso.', 
		'', '', false,
		'MW 9:00am-4:00pm', [clist[0],clist[1]], [slist[2],slist[5]], new Date(), 'mrsoto3', [contact2,contact3]),
	new Resource(783, 'El Paso Dispensary', '7843 Mesa Quemasapplauda Dr', 79983, 
		9152737843, 'contact@dispensaryelpaso.com', 'www.epdispense.org', 
		'Medicinal shop for those in need.', 
		'- Must have a medical id.', '', true,
		'MW 9:00am-4:00pm', [clist[1],clist[2]], [slist[5]], new Date(), 'jkll678', []),
];
rlist[2].lastUpdate.setFullYear(2000);


let editorApp = new Vue({
	el: '#resource-editor',
	data: {
		resources: rlist,
		categories: clist,
		services: slist,
		categorySelectList: [],
		serviceSelectList: [],
		modalResource: null,
		modalCategory: null,
		modalService: null,
		modalContact: null,
		resourceInd: null,
		categoryInd: null,
		serviceInd: null,
		isNewElement: false,
		isNewContact: false,
		selectedCategory: [],
		selectedService: [],
	},
	components: {
		Multiselect: window.VueMultiselect.default,
	},
	methods: {
		formatDate(resource) {
			let date = resource.lastUpdate;
			return `${date.getMonth()+1}/${date.getDate()}/${date.getFullYear()}`;
		},
		isUpdated(date) {
			let today = new Date();
			if (today.getFullYear() > date.getFullYear() || (today.getMonth()-date.getMonth()) > 6)
				return false;
			return true;
		},
		newModalResource() {
			this.selectedCategory = [];
			this.selectedService = [];
			this.isNewElement = true;
			this.modalResource = new Resource();
		},
		newModalCategory() {
			this.selectedCategory = [];
			this.selectedService = [];
			this.isNewElement = true;
			this.modalCategory = new Category();
		},
		newModalService() {
			this.selectedCategory = [];
			this.selectedService = [];
			this.isNewElement = true;
			this.modalService = new Service();
		},
		newModalContact() {
			this.selectedCategory = [];
			this.selectedService = [];
			this.isNewContact= true;
			this.modalContact = new Contact();
		},
		setModalResource(resource) {
			this.selectedCategory = [];
			this.selectedService = [];
			this.isNewElement = false;
			this.modalResource = resource;
		},
		setModalCategory(category) {
			this.selectedCategory = [];
			this.selectedService = [];
			this.isNewElement = false;
			this.modalCategory = category;
		},
		setModalService(service) {
			this.selectedCategory = [];
			this.selectedService = [];
			this.isNewElement = false;
			this.modalService = service;
		},
		setModalContact(contact) {
			this.selectedCategory = [];
			this.selectedService = [];
			this.isNewContact = false;
			this.modalContact = contact;
		},
		addNewContact() {
			console.log('Pushing new contact');
		},
		removeSelectedContact(ind) {
			console.log('Removing contact at ' + ind);
		},
		submit_createResource() {
			this.modalResource.categories = this.selectedCategory;
			this.modalResource.services = this.selectedService;

			if (!this.modalResource || this.modalResource == null) {
				console.log("Error: Add create resource failed\nReason: No resource selected");
				return;
			}
			else if (!this.isNewElement && this.modalResource.id != null) {
				this.submit_updateResource();
				return;
			}
			console.log(`Creating resource`);
			createResource(this.modalResource); // Send resource add request
			this.modalResource = null;
		},
		submit_updateResource() {
			if (!this.modalResource || this.modalResource == null) {
				console.log("Error: Update resource failed\nReason: No resource selected");
				return;
			}
			console.log(`Updating resource_id=${this.modalResource.id}`);
			updateResource(this.modalResource.id, this.modalResource); // Send resource update request
			this.modalResource = null;
		},
		submit_deleteResource() {
			if (!this.modalResource || this.modalResource == null) {
				console.log("Error: Delete resource failed\nReason: No resource selected");
				return;
			}
			console.log(`Deleting resource_id=${this.modalResource.id}`);
			deleteResource(this.modalResource.id); // Send resource delete request
			this.isNewElement = true;
			this.modalResource = null;
		}
	},
})

fetchOptionsList('category', editorApp, 'categorySelectList');
fetchOptionsList('service', editorApp, 'serviceSelectList');
