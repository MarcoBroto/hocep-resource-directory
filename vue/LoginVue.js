
Vue.config.devtools = true; // Vue chrome debugger line, remove in deployment

let loginApp = new Vue({
	el: '#login-app',
	data: {
		failed: false,
	},
});
