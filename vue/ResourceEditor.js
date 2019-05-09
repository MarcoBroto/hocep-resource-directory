
Vue.config.devtools = true; // Vue chrome debugger line, remove in deployment

import Multiselect from 'vue-multiselect';
import Resource from '../js/Resource.js';
import Contact from '../js/Contact.js';
import Tag from '../js/Tag.js';
import { fetchOptionsList } from '../js/fetchMultiselectOptions.js';
import * as Editor from '../js/editor.js';


// Dummy Table Data
var contact1 = new Contact(1, 'Michael', 'Hawk', 'The Dude', '(915) 253-4321', 'micawk@icloud.com');
var contact2 = new Contact(2, 'Michael', 'Hunt', 'The Man', '(915) 253-2331', 'mikunt@icloud.com');
var contact3 = new Contact(3, 'Janet', 'Hanky', 'Jan the Man', '(915) 431-4321', 'janisaman@icloud.com');
let clist = [
	new Tag(1, 'Health', 'Resources pertaining to physical health.'),
	new Tag(2, 'Shelter', 'Resources that provide housing services or living accomodations'),
	new Tag(3, 'Mental Health', 'Resources pertaining to mental health.'),
];
let slist = [
	new Tag(2, 'Tutoring', 'Learning resources.'),
	new Tag(3, 'Hitman', 'First rule of fight club. ;)'),
	new Tag(4, 'Cleaning', 'Basically'),
	new Tag(5, 'Car Repair', 'Repair broken down vehicles.'),
	new Tag(6, 'Wedding Planning', 'Planning wedding parties.'),
];
let rlist = [
	new Resource(13, 'Homeless Shelter of El Paso', '6354 Long Street Road', 79932, 
		9152737843, 'contact@homelssshelterofelpaso.org', 'www.homelssshelterofelpaso.org', 
		'Description of homeless shelter of el paso.', 
		'- Requires new id\n- Some more requirements\n', '', false,
		'MW 9:00am-4:00pm', [clist[0],clist[1]], [slist[2],slist[4]], new Date(), 'mrsoto3', [contact2,contact1,contact3]),
	new Resource(2, 'Shelter Place of El Paso', '6354 Long Street Road', 38293, 
		9152737843, 'contact@homelssshelterofelpaso.org', 'www.shelter.org', 
		'Description of shelter place of el paso.', 
		'Some more requirements\n- JK just come by', '', true,
		'MW 9:00am-4:00pm', [clist[0]], [slist[1],slist[0],slist[4]], new Date(), 'mrsoto3', [contact1]),
	new Resource(9, 'Homeless Bureau', '532 Street Road', 79932, 
		9152737843, 'contact@homelssshelterofelpaso.org', 'www.homelssshelterofelpaso.org', 
		'Description of homeless bureau of el paso.', 
		'', '', false,
		'MW 9:00am-4:00pm', [clist[0],clist[1]], [slist[2],slist[4]], new Date(), 'mrsoto3', [contact2,contact3]),
	new Resource(783, 'El Paso Dispensary', '7843 Mesa Quemasapplauda Dr', 79983, 
		9152737843, 'contact@dispensaryelpaso.com', 'www.epdispense.org', 
		'Medicinal shop for those in need.', 
		'- Must have a medical id.', '', true,
		'MW 9:00am-4:00pm', [clist[1],clist[2]], [slist[4]], new Date(), 'jkll678', []),
];
rlist[2].lastUpdate.setFullYear(2000);


let editorApp = new Vue({
	el: '#resource-editor',

	components: {
		Multiselect: window.VueMultiselect.default,
	},

	data: {
		//
		resources: rlist,
		categories: clist,
		services: slist,
		//
		categorySelectList: [],
		serviceSelectList: [],
		//
		modalResource: null,
		modalCategory: null,
		modalService: null,
		modalContact: null,
		modalTag: null,
		//
		resourceInd: null,
		categoryInd: null,
		serviceInd: null,
		contactInd: null,
		tagInd: null,
		//
		isNewElement: false,
		isNewContact: false,
	},

	methods: {
		formatDate(resource) { // Formats the date object from a resource to month/day/year format
			if (!resource) {
				console.log('Error: Cannot format date.');
				return;
			}
			let date = resource.lastUpdate;
			return `${date.getMonth()+1}/${date.getDate()}/${date.getFullYear()}`;
		},
		isUpdated(date) { // Checks whether a date object is recorded 6 months before the current date
			let today = new Date();
			if (today.getFullYear() > date.getFullYear() || (today.getMonth()-date.getMonth()) > 6)
				return false;
			return true;
		},
		copyObject(obj, type="none") {
			var copy;
			switch (type) {
				case 'resource':
					copy = new Resource();
					break;
				case 'contact':
					copy = new Contact();
					break;
				case 'tag':
					copy = new Tag();
					break;
				default:
					copy = {};
					break;
			}
			Object.assign(copy, obj);
			return copy;
		},

		/*	*/
		resetModalResource() {
			this.modalResource = null;
			this.resourceInd = null;
		},
		resetModalContact() {
			this.modalContact = null;
			this.contactInd = null;
		},
		resetModalTag() {
			this.modalTag = null;
			this.tagInd = null;
		},

		/*	*/
		newModalResource() { // Sets modalResource to a new object
			this.resetModalResource();
			this.isNewElement = true;
			this.modalResource = new Resource();
		},
		newModalContact() {
			this.resetModalContact();
			this.isNewContact= true;
			// this.contactInd = null;
			this.modalContact = new Contact();
		},
		newModalTag() {
			this.resetModalTag();
			this.isNewElement = true;
			this.modalTag = new Tag();
		},

		/*	*/
		setModalResource(resource, ind) {
			this.isNewElement = false;
			this.resourceInd = ind;
			this.modalResource = this.copyObject(resource, 'resource'); // Copy used as the editing canvas, changes saved once confirmed by user.
		},
		setModalContact(contact, ind) {
			this.isNewContact = false;
			this.modalContact = this.copyObject(contact, 'contact'); // Copy used as the editing canvas, changes saved once confirmed by user.
			this.contactInd = ind;
		},
		setModalTag(tag, ind) {
			console.log(tag);
			console.log(ind);
			this.isNewElement = false;
			this.modalTag = this.copyObject(tag, 'tag');
			this.tagInd = ind;
			console.log(this.modalTag);
		},

		/*	*/
		addContact() {
			console.log('Pushing new contact');
			this.modalResource.contactList.push(this.modalContact);
			this.resetModalContact();
		},
		updateContact(ind) {
			if (ind < 0 || !this.modalResource || ind > this.modalResource.contactList.length) {
				console.log('Error updating contact at index ' + ind);
				return;
			}
			console.log('Updating contact at index ' + ind);
			this.modalResource.contactList[this.contactInd] = modalContact;
			this.resetModalContact();
		},
		removeContact(ind) {
			if (ind < 0 || !this.modalResource || ind > this.modalResource.contactList.length) {
				console.log('Error removing contact at index ' + ind);
				return;
			}
			console.log('Removing contact at index ' + ind);
			this.modalResource.contactList.splice(this.contactInd, 1);
			this.resetModalContact();
		},
		
		/*	*/
		create_update_resource() {
			if (!this.modalResource || this.modalResource == null) {
				console.log("Error: Edit resource failed\nReason: No resource saved");
				return;
			}

			// These values are reset with each method call
			this.modalResource.lastUpdate = new Date();
			this.modalResource.zipcode = parseInt(this.modalResource.zipcode);

			if (!this.isNewElement) {
				console.log(`Updating resource_id=${this.modalResource.id}`);
				Editor.updateResource(this.modalResource); // Send resource update request
				Object.assign(this.resources[this.resourceInd], this.modalResource);
			}
			else {
				console.log(`Creating resource`);
				Editor.createResource(this.modalResource); // Send resource add request
				this.resources.push(this.modalResource);
			}
			// Reset modal values
			this.resetModalResource();
			this.isNewElement = true;
		},
		delete_resource() {
			if (!this.modalResource || this.modalResource == null) {
				console.log("Error: Delete resource failed\nReason: No resource selected");
				return;
			}
			else if (isNaN(this.modalResource.id) || this.modalResource.id == null) {
				console.log("Error: Delete resource failed\nReason: Invalid Resource ID");
				return;
			}
			Editor.deleteResource(this.modalResource.id); // Send resource delete request
			this.resources.splice(this.resourceInd, 1);
			
			// Reset modal values
			this.resetModalResource();
			this.isNewElement = true;
		},

		/*	*/
		create_update_tag(type) {
			if (!this.modalTag || this.modalTag == null) {
				console.log(`Error: Edit ${type} failed\nReason: No ${type} saved`);
				return;
			}

			if (!this.isNewElement) {
				Editor.updateTag(type, this.modalTag); // Send tag update request
				if (type == 'category')
					Object.assign(this.categories[this.tagInd], this.modalTag);
				else if (type == 'service')
					Object.assign(this.services[this.tagInd], this.modalTag);
			}
			else {
				console.log(`Creating ${type}`);
				Editor.createTag(type, this.modalTag); // Send resource add request
				if (type == 'category')
					this.categories.push(this.modalTag);
				else if (type == 'service')
					this.services.push(this.modalTag);
			}

			// Reset modal values
			this.resetModalTag();
			this.isNewElement = true;
		},
		delete_tag(type) {
			if (!this.modalTag || this.modalTag == null) {
				console.log(`Error: Delete ${type} failed\nReason: No ${type} saved`);
				return;
			}
			else if (isNaN(this.modalTag.id) || this.modalTag.id == null) {
				console.log(`Error: Delete ${type} failed\nReason: Invalid ${type} ID`);
				return;
			}
			Editor.deleteTag(type, this.modalTag.id); // Send tag delete request
			if (type == 'category')
				this.categories.splice(this.tagInd, 1);
			else if (type == 'service')
				this.services.splice(this.tagInd, 1);
			
			
			// Reset modal values
			this.resetModalTag();
			this.isNewElement = true;
		},
	},

	computed: {
		isValidResource() {
			let resource = this.modalResource;
			return resource.name != null && resource.name !== '' &&
					resource.phone != null && resource.phone !== '' &&
					resource.street != null && resource.street !== '' &&
					resource.zipcode != null && resource.zipcode !== '' &&
					resource.zipcode.toString().length == 5 && !isNaN(resource.zipcode);
		},
		isValidContact() {
			let contact = this.modalContact;
			return contact.fname != null && contact.fname !== '' &&
					contact.lname != null && contact.lname !== '' &&
					contact.phone != null && contact.phone !== '';
		},
		isValidTag() {
			return this.modalTag.name != null && this.modalTag.name !== '';
		},
	}
})

fetchOptionsList('category', editorApp, 'categorySelectList');
fetchOptionsList('service', editorApp, 'serviceSelectList');
