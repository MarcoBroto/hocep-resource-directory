
# Category Procedures

CREATE PROCEDURE addCategory(name VARCHAR, description VARCHAR) BEGIN
	INSERT INTO category (category.name, category.description) VALUES (name, description)
END

CREATE PROCEDURE updateCategory(_id INT, name VARCHAR, description VARCHAR)
	UPDATE category SET category.name=name, category.description=description WHERE service_id=_id
END

CREATE PROCEDURE deleteCategory(_id INT) BEGIN
	DELETE FROM belongs_to WHERE belongs_to.category_id=_id
	DELETE FROM category WHERE category.category_id=_id
END

# Service Procedures

CREATE PROCEDURE addService(name VARCHAR, description VARCHAR) BEGIN
	INSERT INTO service (service.name, service.description) VALUES (name, description)
END

CREATE PROCEDURE updateService(_id INT, name VARCHAR, description VARCHAR)
	UPDATE category SET service.name=name, service.description=description WHERE service.service_id=_id
END

CREATE PROCEDURE deleteService(_id INT) BEGIN
	DELETE FROM provides WHERE provide.service_id=_id
	DELETE FROM service WHERE service.service_id=_id
END

# Resource Procedures

# CREATE PROCEDURE addResource() BEGIN
# CREATE PROCEDURE updateResource(_id INT) BEGIN
# CREATE PROCEDURE deleteResource(_id INT) BEGIN
# CREATE PROCEDURE addContact() BEGIN
# CREATE PROCEDURE updateContact(_id INT) BEGIN
# CREATE PROCEDURE deleteContact(_id INT) BEGIN