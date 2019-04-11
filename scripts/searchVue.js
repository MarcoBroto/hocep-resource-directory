
Vue.config.devtools = true; // Vue chrome debugger line, remove in deployment

class Contact {
	constructor(title, name, phone, email) {
		this.title = title;
		this.name = name;
		this.phone = phone;
		this.email = email;
	}
}

class Organization {
	constructor(id, name, address, phone, email, website, keywords, services, restrictions, qualifications, lastUpdate_date) {
		this._id = id;
		this.name = name;
		this.address = address;
		this.phone = phone;
		this.email = email;
		this.keywords = keywords;
		this.website = website;

		this.restrictions = restrictions;
		this.qualifications = qualifications;
		this.lastUpdate_date = lastUpdate_date;
	}
}

/* Dummy Organization objects */
var outofdate = new Date(1995,6,24);
var org = new Organization('Organization Name', '9151234567', 'email@test.com',
	'www.blank.com', ['Blue', 'Red', 'Aqua',4,3,3,], ['Service 1'],
	'Restrictions are listed here.', 'This is where those Qualifications will be listed.',
	new Date());
var org2 = new Organization('Longer Organization Name', '9151234567', 'email@test.com',
	'www.blank.com', ['Blue', 'Red'], ['Service 1'],
	'Restrictions are listed here.', 'This is where those Qualifications will be listed.',
	new Date());
var org3 = new Organization('Longest Organization Name that probably wont fit', '9151234567',
	'email@testcomputerplace.com', 'www.blank.com', ['Blue', 'Red'], ['Service 1'],
	'Restrictions are listed here.', 'This is where those Qualifications will be listed.',
	outofdate);


/* Vue component for multiselector creator that receives props and available filter options */
Vue.component('selector', {
	props: {
		options: { // Options provided in the select bar
			type: Array,
			required: true,
		},
		multiple: { // if bar can have multiple options selected
			type: Boolean,
			required: false,
		},
		text: { // Placedholder text
			type: String,
			required: false,
		},
	},
	components: {
  		Multiselect: window.VueMultiselect.default,
	},
	template: `

		<div class="multiselector">
			<multiselect
		    v-model="value" 
		    :options="options"
		    :multiple="multiple"
		    :placeholder="text"
		    optionsLimit="4"
		    :max="5"
		    ></multiselect>
	    </div>
	`,
	data() {
		return {
			value: [],
			options: [],
			multiple: false,
		}
	},
	methods: {
		addTag (newTag) {
		      const tag = {
		        name: newTag,
		        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
		      }
		      this.options.push(tag)
		      this.value.push(tag)
		},
	}
});


/* Filter app that gathers user filter inputs and sends query to db */
let app = new Vue({
	el: '#filter-app',
	props: {
		disabled: {
			type: Boolean,
			required: false,
		}
	},
	components: {
  		Multiselect: window.VueMultiselect.default,
	},
  	data: {
		welcome: true,
		disable: false,
	},
	methods: {

	},
	computed: {
		
	}
});


/* Table app that displays organization list */
let tableApp = new Vue({
	el: "#table-app",
	data: {
		isLoading: false,
		isVisible: false,
		orgs: [], // debug values: [org2,org,org3,org3,org,],
		expanded: {},
		slide: false,
	},
	methods: {
        expand(ind) {
        	if (ind in this.expanded) {
        		this.expanded[ind] = !this.expanded[ind];
        	}
        	else
	      		this.$set(this.expanded, ind, true);
    	},
	},
	components: {
		tableRow: {
			template: `
				<tr class="row-box">
					<td class="center row-data-box row-data-box-md">
						<div class="center row-data-keywords-container">
							<div v-for="key in orgData.keywords" class="center keyword-list-item">{{ key }}</div>
						</div>
					</td>
					<td class="row-data-box row-data-box-lg"><div class="row-data-name-container">{{ orgData.name }}</div></td>
					<td class="row-data-box row-data-box-lg"><div class="row-data-addr-container">{{ orgData.address }}</div></td>
					<td class="row-data-box row-data-box-md"><div class="row-data-phone-container">{{ formatPhone(orgData.phone) }}<div></td>
					<td class="row-data-box row-data-box-md"><div class="row-data-email-container"><a :href="'mailto:' + orgData.email">{{ orgData.email }}</a></div></td>
					<td class="row-data-box row-data-box-md"><div class="row-data-web-container"><a href="orgData.website">{{ orgData.website }}</a></div></td>
					<td class="row-data-box row-data-box-sm greenback center" v-if="isUpdated"><strong>Yes</strong></td>
					<td class="row-data-box row-data-box-sm redback center" v-else><strong>No</strong></td>
					<td class="row-data-box-xs center"><button class="view-btn center" @click="expand"><img :src="'assets/' + btn_img" class="center"></button></td>
				</tr>
			`,
			data() {
				return {
					btn_text: 'View',
					btn_img: 'sharp-visibility-24px.svg'
				}
			},
			props: {
				id: {
					type: Number,
					required: false,
				},
				orgData: {
					type: Object,
					required: true,
				}
			},
			methods: {
				formatPhone(phone_num) {
					if (!phone_num || phone_num.length < 10)
						return 'n/a';
					let phone_str = `(${phone_num.slice(0,3)}) ${phone_num.slice(3,6)}-${phone_num.slice(6,phone_num.length)}`;
					return phone_str;
				},
				expand() {
					if (this.btn_text == 'View') {
						this.btn_text = 'Close';
						this.btn_img = 'baseline-visibility_off-24px.svg';
					}
					else {
						this.btn_text = 'View';
						this.btn_img = 'sharp-visibility-24px.svg';
					}
          			this.$emit('expand', this.id);
        		},
			},
			computed: {
				isUpdated: function() {
					let date = new Date(this.orgData.lastUpdate_date);
					let today = new Date();
					if (today.getFullYear() > date.getFullYear() || (today.getMonth()-date.getMonth()) > 6)
						return false;
					return true;
				},
			}
		},
		tableSubrow: {
			props: {
				orgData: {
					type: Object,
					required: true,
				}
			},
			template: `
				<tr class="subrow-box">
					<td rowspan="1" colspan="8">
						<div class="subrow-data-box subrow-data-box-lg">
							<div class="subrow-data-box-sub subrow-data-box-sub-top">
								<strong>Qualifications:</strong><br/>
								{{ orgData.qualifications }}
							</div>
							<div class="subrow-data-box-sub subrow-data-box-sub-bottom">
								<strong>Restrictions:</strong><br/>
								{{ orgData.restrictions }}
							</div>
						</div>
						
						<div class="subrow-data-box subrow-data-box-lg">
							<div class="subrow-data-box-sub subrow-data-box-sub-top">
								<strong>Services Offered:</strong><br/>
							</div>
							<div class="subrow-data-box-sub subrow-data-box-sub-bottom">
								<strong>Documentation Needed:</strong><br/>
							</div>
						</div>

						<div class="subrow-data-box subrow-data-box-lg subrow-data-box-sub">
							<strong>Contact List:</strong><br/>
						</div>

						<div class="subrow-data-box subrow-data-box-sm">
							<div class="subrow-data-box-sub subrow-data-box-top">
								<strong>Last Updated:</strong><br/>
								{{ orgData.lastUpdate_date.toDateString() }}
							</div>
							<div class="subrow-data-box-sub subrow-data-box-bottom">
								<strong>Hours of Operation:</strong><br/>
							</div>
						</div>
					</td>
				</tr>
			`,
		}
	},
});

