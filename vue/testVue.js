
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
