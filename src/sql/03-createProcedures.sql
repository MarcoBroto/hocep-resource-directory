USE `oc_db`; # Set default schema

DROP PROCEDURE IF EXISTS `add_resource`;
DROP PROCEDURE IF EXISTS `add_category`;
DROP PROCEDURE IF EXISTS `add_service`;
DROP PROCEDURE IF EXISTS `add_contact`;
DROP PROCEDURE IF EXISTS `update_resource`;
DROP PROCEDURE IF EXISTS `update_category`;
DROP PROCEDURE IF EXISTS `update_contact`;
DROP PROCEDURE IF EXISTS `update_service`;
DROP PROCEDURE IF EXISTS `delete_resource`;
DROP PROCEDURE IF EXISTS `delete_category`;
DROP PROCEDURE IF EXISTS `delete_service`;
DROP PROCEDURE IF EXISTS `delete_contact`;
DROP PROCEDURE IF EXISTS `link_category`;
DROP PROCEDURE IF EXISTS `link_service`;
DROP PROCEDURE IF EXISTS `link_admin`;
DROP PROCEDURE IF EXISTS `link_contact`;

DELIMITER $$

# Add Procedures

CREATE PROCEDURE `add_resource` (IN title VARCHAR(200), IN street VARCHAR(100), IN zip INT, IN phone VARCHAR(20), IN website VARCHAR(200), IN email VARCHAR(200), IN description VARCHAR(500), IN requirements VARCHAR(500), IN documents VARCHAR(500), IN opHours VARCHAR(350), IN insurance BOOLEAN)
BEGIN
	INSERT INTO resource (resource.title, resource.street_address, resource.zipcode, resource.phone, resource.website, resource.email, resource.description, resource.requirements, resource.documents, resource.opHours, resource.insurance)
	VALUES (title, street, zip, phone, website, email, description, requirements, documents, opHours, insurance)
	ON DUPLICATE KEY UPDATE resource.title = title, resource.street_address = street, resource.zipcode = zip, resource.phone = phone, resource.website = website, resource.email = email, resource.description = description, resource.requirements = requirements, resource.documents = documents, resource.opHours = opHours, resource.insurance = insurance;
END$$


CREATE PROCEDURE `add_category` (IN name VARCHAR(100), IN description VARCHAR(500))
BEGIN
	INSERT INTO category (category.name, category.description) VALUES (name, description)
    ON DUPLICATE KEY UPDATE category.name = name, category.description = description;
END$$


CREATE PROCEDURE `add_contact` (IN resource_id INT, IN fname VARCHAR(50), IN lname VARCHAR(50), IN title VARCHAR(50), IN phone VARCHAR(20), IN email VARCHAR(200))
BEGIN
	INSERT INTO contact (contact.resource_id, contact.f_name, contact.l_name, contact.title, contact.phone, contact.email)
	VALUES (resource_id, fname, lname, title, phone, email)
	ON DUPLICATE KEY UPDATE contact.resource_id = resource_id, contact.f_name=fname, contact.l_name=lname, contact.title=title, contact.phone=phone, contact.email=email;
END$$


CREATE PROCEDURE `add_service` (IN name VARCHAR(100), IN description VARCHAR(255))
BEGIN
	INSERT INTO service (service.name, service.description) VALUES (name, description)
	ON DUPLICATE KEY UPDATE service.name = name, service.description = description;
END$$


# Delete procedures

CREATE PROCEDURE `delete_resource` (IN resource_id INT)
BEGIN
	DELETE FROM resource WHERE resource.resource_id=resource_id;
END$$


CREATE PROCEDURE `delete_category` (IN category_id INT)
BEGIN
	DELETE FROM category WHERE category.category_id=category_id;
END$$


CREATE PROCEDURE `delete_contact` (IN contact_id INT)
BEGIN
	DELETE FROM contact WHERE contact.contact_id=contact_id;
END$$


CREATE PROCEDURE `delete_service` (IN service_id INT)
BEGIN
	DELETE FROM service WHERE service.service_id=service_id;
END$$


# Link procedures

CREATE PROCEDURE `link_admin` (IN admin_username VARCHAR(20), IN resource_id INT)
BEGIN
	SELECT admin_id INTO @AID FROM `admin` WHERE username=admin_username;
	INSERT INTO updates VALUES (DATE(NOW()), @AID, resource_id)
    ON DUPLICATE KEY UPDATE updates.date = DATE(NOW()), updates.admin_id = @AID, updates.resource_id = resource_id;
END$$


CREATE PROCEDURE `link_category` (IN resource_id INT, IN category_id INT)
BEGIN
	INSERT INTO belongs_to VALUES(resource_id, category_id) 
    ON DUPLICATE KEY UPDATE belongs_to.resource_id = resource_id, belongs_to.category_id = category_id;
END$$


CREATE PROCEDURE `link_service` (IN resource_id INT, IN service_id INT)
BEGIN
	INSERT INTO provides VALUES (resource_id, service_id)
    ON DUPLICATE KEY UPDATE provides.resource_id = resource_id, provides.service_id = service_id;
END$$


# update procedures

CREATE PROCEDURE `update_resource` (IN resource_id INT, IN title VARCHAR(200), IN street VARCHAR(100), IN zip INT, IN phone VARCHAR(20), IN website VARCHAR(200), IN email VARCHAR(200), IN description VARCHAR(500), IN requirements VARCHAR(500), IN documents VARCHAR(500), IN opHours VARCHAR(350), IN insuranceRequired BOOLEAN, IN adminUsername VARCHAR(20))
BEGIN
	UPDATE resource SET resource.title=title, resource.street_address=street, resource.zipcode=zip, resource.phone=phone, resource.website=website, resource.email=email, resource.description=description, resource.requirements=requirements, resource.documents=documents, resource.opHours=opHours, resource.insurance=insuranceRequired
	WHERE resource.resource_id=resource_id;
    CALL link_admin(adminUsername, resource_id);
END$$


CREATE PROCEDURE `update_category` (IN category_id INT, IN name VARCHAR(100), IN description VARCHAR(500))
BEGIN
	UPDATE category SET category.name=name, category.description=description WHERE category.category_id=category_id;
END$$


CREATE PROCEDURE `update_contact` (IN contact_id INT, IN resource_id INT, IN fname VARCHAR(50), IN lname VARCHAR(50), IN title VARCHAR(50), IN phone VARCHAR(50), IN email VARCHAR(200))
BEGIN
	UPDATE contact SET contact.resource_id=resource_id, contact.f_name=fname, contact.l_name=lname, contact.title=title, contact.phone=phone, contact.email=email WHERE contact.contact_id=contact_id;
END$$


CREATE PROCEDURE `update_service` (IN service_id INT, IN name VARCHAR(100), IN description VARCHAR(255))
BEGIN
	UPDATE service SET service.name=name, service.description=description WHERE service.service_id=service_id;
END$$


DELIMITER ;