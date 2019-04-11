
Vue.config.devtools = true;

Vue.component("ResourceItem", {
	props: {
		id: {
			type: Number,
			required: false,
		},
		resource: {
			type: Object,
			required: true,
		},
	},
	template: `
		
	`,
	data() {
		return {
			btn_text: 'View',
			btn_expand_img: 'baseline-keyboard_arrow_down_black-24px.svg',
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
				this.btn_expand_img = 'baseline-keyboard_arrow_down_black-24px.svg';
			}
			else {
				this.btn_text = 'View';
				this.btn_expand_img = 'baseline-keyboard_arrow_up_black-24px.svg';
			}
  			this.$emit('expand', this.id); // Send expand message to list container
		},
		isUpdated() {
			let date = new Date(this.resource.lastUpdate_date);
			let today = new Date();
			if (today.getFullYear() > date.getFullYear() || (today.getMonth()-date.getMonth()) > 6)
				return false;
			return true;
		},
	},
	computed: {

	}
})