
DELIMETER $$

--Drop Procedures if they already exist
DROP PROCEDURE IF EXISTS addCategory;
DROP PROCEDURE IF EXISTS updateCategory;
DROP PROCEDURE IF EXISTS deleteCategory;
DROP PROCEDURE IF EXISTS addService;
DROP PROCEDURE IF EXISTS updateService;
DROP PROCEDURE IF EXISTS deleteService;
DROP PROCEDURE IF EXISTS addResource;
DROP PROCEDURE IF EXISTS updateResource;
DROP PROCEDURE IF EXISTS deleteResource;
DROP PROCEDURE IF EXISTS linkCategory;
DROP PROCEDURE IF EXISTS linkService;
DROP PROCEDURE IF EXISTS linkContact;


------------Category Procedures------------

# Category Create
CREATE PROCEDURE addCategory(IN name VARCHAR(100), IN description VARCHAR(500)) BEGIN
	INSERT INTO category (category.name, category.description) VALUES (name, description);
END

# Category Update
CREATE PROCEDURE updateCategory(IN category_id INT, IN name VARCHAR, IN description VARCHAR)
	UPDATE category SET category.name=name, category.description=description WHERE service_id=category_id;
END

# Category Delete
CREATE PROCEDURE deleteCategory(IN category_id INT) BEGIN
	DELETE FROM belongs_to WHERE belongs_to.category_id=category_id;
	DELETE FROM category WHERE category.category_id=category_id;
END


------------Service Procedures------------

# Service Create
CREATE PROCEDURE addService(name VARCHAR, description VARCHAR) BEGIN
	INSERT INTO service (service.name, service.description) VALUES (name, description)
	ON DUPLICATE KEY CALL updateService();
END

# Service Update
CREATE PROCEDURE updateService(service_id INT, name VARCHAR, description VARCHAR)
	UPDATE category SET service.name=name, service.description=description WHERE service.service_id=service_id;
END

#Service Delete
CREATE PROCEDURE deleteService(service_id INT) BEGIN
	DELETE FROM provides WHERE provide.service_id=service_id;
	DELETE FROM service WHERE service.service_id=service_id;
END


 ------------Contact Procedures------------

# Contact Create, also used as a the link procedure
CREATE PROCEDURE addContact(fname VARCHAR, lname VARCHAR, title VARCHAR, phone VARCHAR, email VARCHAR) BEGIN
	INSERT INTO contact (contact.f_name, contact.l_name, contact.title, contact.phone, contact.email)
	VALUES (fname, lname, phone, email);
	ON DUPLICATE KEY UPDATE contact SET contact.f_name=fname, contact.l_name=lname, contact.title=title, contact.phone=phone, contact.email=email;
END

# Contact Update
CREATE PROCEDURE updateContact(contact_id INT, resource_id INT, fname VARCHAR, lname VARCHAR, title VARCHAR, phone VARCHAR, email VARCHAR) BEGIN
	UPDATE contact SET contact.resource_id=resource_id, contact.f_name=fname, contact.l_name=lname, contact.title=title, contact.phone=phone, contact.email=email WHERE contact.contact_id=contact_id;
END

# Contact Delete
CREATE PROCEDURE deleteContact(contact_id INT) BEGIN
	DELETE FROM contact WHERE contact.contact_id=contact_id;
END

------------Resource Procedures------------

# Resource Create
CREATE PROCEDURE addResource(resource_id VARCHAR, name VARCHAR, street VARCHAR, zip INT, website VARCHAR, email VARCHAR, description VARCHAR, requirements VARCHAR, documents VARCHAR, opHours VARCHAR, insuranceRequired BOOLEAN) BEGIN
	INSERT INTO resource (resource.resource_id, resource.title, resource.street_address, resource.zipcode, resource.website, resource.email, resource.description, resource.requirements, resource.documents, resource.hoursOfOp, documents.insurance)
	VALUES (resource_id, name, street, zip, website, email, description, requirements, documents, opHours, insuranceRequired)
	ON DUPLICATE resource.resource_id CALL updateResource()
END

# Resource Update
CREATE PROCEDURE updateResource(resource_id VARCHAR, name VARCHAR, street VARCHAR, zip INT, website VARCHAR, email VARCHAR, description VARCHAR, requirements VARCHAR, documents VARCHAR, opHours VARCHAR, insuranceRequired BOOLEAN) BEGIN
	UPDATE resource SET resource.resource_id=resource_id, resource.title=title, resource.street_address=street, resource.zipcode=zip, resource.website=website, resource.email=email, resource.description=description, resource.requirements=requirements, resource.documents=documents, resource.hoursOfOp=opHours, documents.insurance=insuranceRequired
	WHERE resource.resource_id=resource_id;
END

# Resource Delete
CREATE PROCEDURE deleteResource(resource_id INT) BEGIN
	DELETE FROM resource WHERE resoure.resource_id=resource_id;
END

------------Link Procedures------------

# Link Category to Resource
CREATE PROCEDURE linkCategory(category_id, resource_id) BEGIN
	
END

# Link Service to Resource
CREATE PROCEDURE linkService(service_id, resource_id) BEGIN

END

# Link Contact to Resource
CREATE PROCEDURE linkContact(contact_id, resource_id) BEGIN
	INSERT INTO contact (contact.contact_id, contact.f_name, contact._l_name, contact.title, contact.phone, contact.email)
	VALUES ()
	ON DUPLICATE KEY 
END

$$
