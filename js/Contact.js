
export default class Contact {
	constructor(contact_id, first_name, last_name, title, phone_num, email) {
		this.id = contact_id;
		this.fname = first_name;
		this.lname = last_name;
		this.title = title;
		this.phone = phone_num;
		this.email = email;
	}

	fullname() {
		return `${this.fname} ${this.lname}`;
	}
}
