
export default class Resource {
	constructor(resource_id=null, resource_name=null, street=null, zipcode=null, 
			resource_phone=null, resource_email="", resource_website="", resource_descrip="",
			resource_requirements="", resource_documents="", insurance_required=false, 
			hoursOfOperation="", resource_category=[], resource_service=[],
			lastUpdate_date=new Date(), lastUpdate_admin=null, contact_list=[]) {
		this.id = resource_id;
		this.name = resource_name;
		this.street = street;
		this.zipcode = zipcode;
		this.phone = resource_phone;
		this.email = resource_email;
		this.website = resource_website;
		this.description = resource_descrip;
		this.requirements = resource_requirements;
		this.documents = resource_documents;
		this.needInsurance = insurance_required;
		this.opHours = hoursOfOperation;
		this.categories = resource_category;
		this.services = resource_service;
		this.lastUpdate = lastUpdate_date;
		this.lastUpdate_admin = lastUpdate_admin
		this.contactList = contact_list;
	}

	getAddress() {
		return `${this.street} ${this.zipcode}`;
	}
}
