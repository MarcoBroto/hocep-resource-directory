
export class Resource {
	constructor(resource_id, resource_name, street, zipcode, 
			resource_phone, resource_email, resource_website, resource_descrip,
			resource_requirements, resource_documents, insurance_required, 
			hoursOfOperation, resource_category, resource_service,
			lastUpdate_date, lastUpdate_admin, contact_list) {
		this.id = resource_id;
		this.name = resource_name;
		this.street = street;
		this.zipcode = zipcode;
		this.phone = resource_phone;
		this.email = resource_email;
		this.website = resource_website;
		this.description = resource_descrip
		this.requirements = resource_requirements;
		this.documents = resource_documents;
		this.needInsurance = insurance_required;
		this.opHours = hoursOfOperation;
		this.categories = resource_category;
		this.services = resource_service;
		this.lastUpdate = lastUpdate_date;
		this.lastUpdate_admin = lastUpdate_admin
		this.address = `${street} ${zipcode}`;
		this.contactList = contact_list;
	}
}
