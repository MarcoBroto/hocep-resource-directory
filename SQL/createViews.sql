
#######################
#### Listing Views ####

# Get list of names of all available resources. Used for front-end selection menus.
CREATE OR REPLACE VIEW `resource_list` AS (
	SELECT title AS 'name', resource_id as 'id' FROM Resource ORDER BY title
);

# Get list of names of all available zipcodes. Used for front-end selection menus.
CREATE OR REPLACE VIEW `zipcode_list` AS (
	SELECT distinct(zipcode) FROM resource ORDER BY zipcode
);

# Get list of names of all available categories. Used for front-end selection menus.
CREATE OR REPLACE VIEW `category_list` AS (
	SELECT name, category_id AS 'id' FROM category ORDER BY name
);

# Get list of names of all available services. Used for front-end selection menus. 
CREATE OR REPLACE VIEW `service_list` AS (
	SELECT name, service_id AS 'id' FROM service ORDER BY name
);

######################
### Grouping Views ###

# Gets list of Admins and login credentials. Used for login page validation.
CREATE OR REPLACE VIEW `admin_logins` AS (
	SELECT username, password FROM Admin
);

# Merge all categories associated with each resource into JSON array. Join into search_rows view.
CREATE OR REPLACE VIEW `category_grouped` AS (
	SELECT resource_id, JSON_ARRAYAGG(name) AS 'categories' FROM category
	JOIN belongs_to ON category.category_id=belongs_to.category_id 
	GROUP BY resource_id
);

# Merge all categoryies associated with each resource into JSON array. Join into editor_rows view.
CREATE OR REPLACE VIEW `category_grouped_editor` AS (
	SELECT resource_id, JSON_ARRAYAGG(JSON_OBJECT('name', name, 'id', category.category_id)) AS 'categories' FROM category
	JOIN belongs_to ON category.category_id=belongs_to.category_id 
    GROUP BY resource_id
);

# Merge all services associated with each resource into JSON array. Join into search_rows view.
CREATE OR REPLACE VIEW `service_grouped` AS (
	SELECT resource_id, JSON_ARRAYAGG(name) AS 'services' FROM service
	JOIN provides ON service.service_id=provides.service_id
	GROUP BY resource_id
);

# Merge all services associated with each resource into JSON array. Join into editor_rows view.
CREATE OR REPLACE VIEW `service_grouped_editor` AS (
	SELECT resource_id, JSON_ARRAYAGG(JSON_OBJECT('name', name, 'id', service.service_id)) AS 'services' FROM service
	JOIN provides ON service.service_id=provides.service_id
	GROUP BY resource_id
);

# Create JSON objects from each field of a contact. Will be merged into array in contact_grouped view.
CREATE OR REPLACE VIEW `contact_objects` AS (
	SELECT resource_id, json_object('id',contact_id, 'title',title, 'fname',f_name, 'lname',l_name,'phone',phone, 'email',email) AS contact FROM contact
);

# Merge all contact JSON objects into JSON array. Will be joined into data row views. 
CREATE OR REPLACE VIEW `contact_grouped` AS (
	SELECT resource_id, JSON_ARRAYAGG(contact) AS contacts FROM contact_objects
	GROUP BY resource_id
);

# Merge Updates and Admin tables to be used to merge into edit_row view
CREATE OR REPLACE VIEW `updates_w_admin` AS (
	SELECT updates.admin_id as 'admin_id', resource_id, username, updates.date FROM updates
	JOIN admin ON updates.admin_id=admin.admin_id
);

##########################
### Data Display Views ###

# View for Resource Editor app, must have all data associated with each row
CREATE OR REPLACE VIEW `editor_rows` AS (
	SELECT resource.resource_id AS 'id', title AS 'name', categories, services, street_address AS 'street', zipcode, phone, email, website, description, documents, requirements, insurance, opHours, contacts AS 'contactList', admin_id, username AS 'lastUpdate_admin', updates_w_admin.date AS 'lastUpdate' FROM resource
	LEFT JOIN category_grouped_editor ON resource.resource_id=category_grouped_editor.resource_id
	LEFT JOIN service_grouped_editor ON resource.resource_id=service_grouped_editor.resource_id
	LEFT JOIN contact_grouped ON resource.resource_id=contact_grouped.resource_id
	LEFT JOIN updates_w_admin ON resource.resource_id=updates_w_admin.resource_id
	ORDER BY name
);

# View for Search Page app, must have all data associated with each row except for the username of the  admin who updated the document.
CREATE OR REPLACE VIEW `search_rows` AS (
	SELECT resource.resource_id AS 'id', title AS 'name', categories, services, street_address AS 'street', zipcode, phone, email, website, description, documents, requirements, insurance, opHours, contacts AS 'contactList', updates.date AS 'lastUpdate' FROM resource
	LEFT JOIN category_grouped ON resource.resource_id=category_grouped.resource_id
	LEFT JOIN service_grouped ON resource.resource_id=service_grouped.resource_id
	LEFT JOIN contact_grouped ON resource.resource_id=contact_grouped.resource_id
	LEFT JOIN updates ON resource.resource_id=updates.resource_id
	ORDER BY name
);
