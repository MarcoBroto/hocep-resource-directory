
import Multiselect from 'vue-multiselect';
import Resource from '../js/Resource.js';
import Contact from '../js/Contact.js';
import Tag from '../js/Tag.js';
import { fetchOptionsList } from '../js/fetchMultiselectOptions.js';
import * as Editor from '../js/editor.js';


let editorApp = new Vue({
	el: '#resource-editor',

	components: {
		Multiselect: window.VueMultiselect.default,
	},

	data: {
		admin: username,

		/*
		 * Stores the visible lists that are contained in the database
		 * and that the administrator can edit.
		 */
		resources: [],
		categories: [],
		services: [],

		// Stores the available options in the vue multiselectors displayed in the resource modal interface.
		categorySelectList: [],
		serviceSelectList: [],

		/*
		 * Will contain copies of the objects selected in the editor that
		 * can be edited. The objectwill be changed in the interface and within
		 * the database once the administrator confirms the changes.
		 */
		modalResource: null,
		modalContact: null,
		modalTag: null,

		// Will store the index of the object being modified in the diplayable list.
		resourceInd: null,
		contactInd: null, // Stores the index of the contact within the current resource being modified.
		tagInd: null,

		// Determines if a new object is being created and will take actions to create new instance.
		isNewElement: false,
		isNewContact: false,
	},

	methods: {
		formatDate(resource) { // Formats the date object from a resource to mm/dd/yyyy format
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

		/*
		 * These methods are used to reset the states and copies 
		 * of objects being edited from the modal interfaces.
		 */
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

		/*
		 * These methods are used for creating a new instance of the object 
		 * being created and edited in the modal interface.
		 */
		newModalResource() {
			this.resetModalResource();
			this.isNewElement = true;
			this.modalResource = new Resource();
			this.modalResource.lastUpdate_admin = this.admin;
		},
		newModalContact() {
			this.resetModalContact();
			this.isNewContact= true;
			this.contactInd = null;
			this.modalContact = new Contact();
		},
		newModalTag() {
			this.resetModalTag();
			this.isNewElement = true;
			this.modalTag = new Tag();
		},

		/*
		 * These methods are used for copying an object that is already in existence that will 
		 * be used by the modal interface to edit the current contents. The changes are saved
		 * once they are submitted to the database.
		 */
		setModalResource(resource, ind) {
			this.isNewElement = false;
			this.resourceInd = ind;
			this.modalResource = Object.assign(new Resource(), resource); // Copy used as the editing canvas, changes saved once confirmed by user.
			this.modalResource.lastUpdate_admin = this.admin;
		},
		setModalContact(contact, ind) {
			this.isNewContact = false;
			this.modalContact = Object.assign(new Contact(), contact); // Copy used as the editing canvas, changes saved once confirmed by user.
			this.contactInd = ind;
		},
		setModalTag(tag, ind) {
			this.isNewElement = false;
			this.modalTag = Object.assign(new Tag(), tag);
			this.tagInd = ind;
		},

		/* The following methods manage the contact list of a particular resource. */
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
			// Reset modal state
			this.resetModalContact();
		},
		
		/*
		 * The following methods submit the CRUD operations for resources to the database
		 * using ajax requests. The results are then handles accordingly.
		 */
		create_update_resource() {
			if (!this.modalResource || this.modalResource == null) {
				console.log("Error: Edit resource failed\nReason: Modal Resource not set.");
				return;
			}

			// These values are reset with each method call
			this.modalResource.lastUpdate = new Date();
			this.modalResource.zipcode = parseInt(this.modalResource.zipcode);

			if (!this.isNewElement) {
				console.log(`Updating resource_id=${this.modalResource.id}`);
				Editor.updateResource(this.modalResource, this, this.resourceInd); // Send resource update request
			}
			else {
				console.log(`Creating resource`);
				Editor.createResource(this.modalResource, this); // Send resource add request
			}
			// The list of resources is updated in the request callback

			// Reset modal state
			this.resetModalResource();
			this.isNewElement = true;
		},
		delete_resource() {
			if (!this.modalResource || this.modalResource == null) {
				console.log("Error: Delete resource failed\nReason: Modal resource not set.");
				return;
			}
			else if (isNaN(this.modalResource.id) || this.modalResource.id == null) {
				console.log("Error: Delete resource failed\nReason: Invalid Resource ID");
				return;
			}
			Editor.deleteResource(this.modalResource.id, this, this.resourceInd); // Send resource delete request
			// The list of resources is updated in the request callback
			
			// Reset modal state
			this.resetModalResource();
			this.isNewElement = true;
		},

		/*
		 * The following methods submit the CRUD operations for tags [service & category] to the database using ajax requests. 
		 * The results are then handles accordingly.
		 */
		create_update_tag(type) {
			if (!this.modalTag || this.modalTag == null) {
				console.log(`Error: Edit ${type} failed\nReason: No ${type} saved`);
				return;
			}

			if (!this.isNewElement) {
				Editor.updateTag(type, this.modalTag, this, this.tagInd); // Send tag update request
			}
			else {
				console.log(`Creating ${type}`);
				Editor.createTag(type, this.modalTag, this); // Send resource add request
			}
			// The list of tags is updated in the request callback

			// Reset modal state
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
			Editor.deleteTag(type, this.modalTag.id, this, this.tagInd); // Send tag delete request
			// The list of tags is updated in the request callback

			// Reset modal state
			this.resetModalTag();
			this.isNewElement = true;
		},
	},

	computed: {
		isValidResource() { // Determines if the resource currently being edited is valid for being saved and submitted.
			let resource = this.modalResource;
			return resource.name != null && resource.name !== '' &&
					resource.phone != null && resource.phone !== '' &&
					resource.street != null && resource.street !== '' &&
					resource.zipcode != null && resource.zipcode !== '' &&
					resource.zipcode.toString().length == 5 && !isNaN(resource.zipcode);
		},
		isValidContact() { // Determines if the resource contact currently being edited is valid for being saved and submitted.
			let contact = this.modalContact;
			return contact.fname != null && contact.fname !== '' &&
					contact.lname != null && contact.lname !== '' &&
					contact.phone != null && contact.phone !== '';
		},
		isValidTag() { // Determines if the tag [service or category] being edited is valid for being saved and submitted.
			return this.modalTag.name != null && this.modalTag.name !== '';
		},
	}
})

/* Fetch the available options for the vue multiselectors in the resource modal interface. Used to select category or service.*/
fetchOptionsList('category', editorApp, 'categorySelectList');
fetchOptionsList('service', editorApp, 'serviceSelectList');
/* Refresh the current list of items for the interface lists that the administrator can edit. */
Editor.refreshResources(editorApp);
Editor.refreshTags('category', editorApp);
Editor.refreshTags('service', editorApp);
