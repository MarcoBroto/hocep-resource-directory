
# add Procedures
CREATE PROCEDURE addResource (title VARCHAR(200), street VARCHAR(100), zip INT, phone VARCHAR(20), website VARCHAR(200), email VARCHAR(200), description VARCHAR(500), requirements VARCHAR(500), documents VARCHAR(500), opHours VARCHAR(350), insurance BOOLEAN)
BEGIN
	INSERT INTO resource (resource.title, resource.street_address, resource.zipcode, resource.phone, resource.website, resource.email, resource.description, resource.requirements, resource.documents, resource.opHours, resource.insurance)
	VALUES (title, street, zip, phone, website, email, description, requirements, documents, opHours, insurance)
	ON DUPLICATE KEY UPDATE resource.title = title, resource.street_address = street, resource.zipcode = zip, resource.phone = phone, resource.website = website, resource.email = email, resource.description = description, resource.requirements = requirements, resource.documents = documents, resource.opHours = opHours, resource.insurance = insurance;
END

CREATE PROCEDURE addCategory (IN name VARCHAR(100), IN description VARCHAR(500))
BEGIN
	INSERT INTO category (category.name, category.description) VALUES (name, description)
    ON DUPLICATE KEY UPDATE category.name = name, category.description = description;
END

CREATE PROCEDURE addContact (resource_id INT, fname VARCHAR(50), lname VARCHAR(50), title VARCHAR(50), phone VARCHAR(20), email VARCHAR(200))
BEGIN
	INSERT INTO contact (contact.resource_id, contact.f_name, contact.l_name, contact.title, contact.phone, contact.email)
	VALUES (resource_id, fname, lname, title, phone, email)
	ON DUPLICATE KEY UPDATE contact.resource_id = resource_id, contact.f_name=fname, contact.l_name=lname, contact.title=title, contact.phone=phone, contact.email=email;
END

CREATE PROCEDURE addService (name VARCHAR(100), description VARCHAR(255))
BEGIN
	INSERT INTO service (service.name, service.description) VALUES (name, description)
	ON DUPLICATE KEY UPDATE service.name = name, service.description = description;
END


# delete procedures
CREATE PROCEDURE deleteCategory (IN category_id INT)
BEGIN
	DELETE FROM category WHERE category.category_id=category_id;
END

CREATE PROCEDURE deleteContact (contact_id INT)
BEGIN
	DELETE FROM contact WHERE contact.contact_id=contact_id;
END

CREATE PROCEDURE deleteResource (resource_id INT)
BEGIN
	DELETE FROM resource WHERE resource.resource_id=resource_id;
END

CREATE PROCEDURE deleteService (service_id INT)
BEGIN
	DELETE FROM service WHERE service.service_id=service_id;
END


# link procedures
CREATE PROCEDURE linkAdmin (admin_id INT, resource_id INT, date DATE)
BEGIN
	INSERT INTO updates VALUES(date, admin_id, resource_id)
    ON DUPLICATE KEY UPDATE updates.date = date, updates.admin_id = admin_id, updates.resource_id = resource_id;
END


CREATE PROCEDURE linkCategory (resource_id INT, category_id INT)
BEGIN
	INSERT INTO belongs_to VALUES(resource_id, category_id) 
    ON DUPLICATE KEY UPDATE belongs_to.resource_id = resource_id, belongs_to.category_id = category_id;
END


CREATE PROCEDURE linkService (resource_id INT, service_id INT)
BEGIN
	INSERT INTO provides VALUES (resource_id, service_id)
    ON DUPLICATE KEY UPDATE provides.resource_id = resource_id, provides.service_id = service_id;
END


# update procedures
CREATE PROCEDURE updateCategory (IN category_id INT, IN name VARCHAR(100), IN description VARCHAR(500))
BEGIN
	UPDATE category SET category.name=name, category.description=description WHERE category.category_id=category_id;
END

CREATE PROCEDURE updateContact (contact_id INT, resource_id INT, fname VARCHAR(50), lname VARCHAR(50), title VARCHAR(50), phone VARCHAR(50), email VARCHAR(200))
BEGIN
	UPDATE contact SET contact.resource_id=resource_id, contact.f_name=fname, contact.l_name=lname, contact.title=title, contact.phone=phone, contact.email=email WHERE contact.contact_id=contact_id;
END

CREATE PROCEDURE updateResource (resource_id INT, title VARCHAR(200), street VARCHAR(100), zip INT, phone VARCHAR(20), website VARCHAR(200), email VARCHAR(200), description VARCHAR(500), requirements VARCHAR(500), documents VARCHAR(500), opHours VARCHAR(350), insuranceRequired BOOLEAN)
BEGIN
	UPDATE resource SET resource.title=title, resource.street_address=street, resource.zipcode=zip, resource.phone=phone, resource.website=website, resource.email=email, resource.description=description, resource.requirements=requirements, resource.documents=documents, resource.opHours=opHours, resource.insurance=insuranceRequired
	WHERE resource.resource_id=resource_id;
END

CREATE PROCEDURE updateService (service_id INT, name VARCHAR(100), description VARCHAR(255))
BEGIN
	UPDATE service SET service.name=name, service.description=description WHERE service.service_id=service_id;
END





