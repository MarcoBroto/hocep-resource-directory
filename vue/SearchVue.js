
import Multiselect from 'vue-multiselect';
import { sendSearchRequest } from '../js/search.js';
import { fetchOptionsList } from '../js/fetchMultiselectOptions.js';


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

