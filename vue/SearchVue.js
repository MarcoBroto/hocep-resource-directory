
import Multiselect from 'vue-multiselect';
import { sendSearchRequest } from '../js/search.js';
import { fetchOptionsList } from '../js/fetchMultiselectOptions.js';


let app = new Vue({
	el: '#resource-table-app',
	components: {
		Multiselect: window.VueMultiselect.default,
	},
	data: {
		welcome: true, // Used to display banner and hide resource list
		isLoading: false, // Used to display loading wheel

		// Contains the options the user can select from the vue multiselectors
		resourceSelectList: [],
		categorySelectList: [],
		serviceSelectList: [],
		zipcodeSelectList: [],

		// Contains the options the user has selected that will be used in the search query
		selectedResource: [],
		selectedService: [],
		selectedCategory: [],
		selectedZipcode: [],
		insuranceNotRequired: false,
		
		// Contains the resources that were returned from the query that match the user selected criteria.
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
			params['insurance'] = this.insuranceNotRequired;
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

