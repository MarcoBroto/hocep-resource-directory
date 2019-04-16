
#######################
#### Listing Views ####

# Get list of names of all available resources. Used for front-end selection menus.
CREATE VIEW resource_list AS (
	SELECT name FROM Resource ORDER BY name
);

# Get list of names of all available zipcodes. Used for front-end selection menus.
CREATE VIEW zipcode_list AS (
	SELECT distinct(zipcode) FROM Resource ORDER BY zipcode
);

# Get list of names of all available categories. Used for front-end selection menus.
CREATE VIEW category_list AS (
	SELECT name FROM Category ORDER BY name
);

# Get list of names of all available services. Used for front-end selection menus. 
CREATE VIEW service_list AS (
	SELECT name FROM Service ORDER BY name
);

######################
### Grouping Views ###

# Gets list of Admins and login credentials. Used for login page validation.
CREATE VIEW admin_logins AS (
	SELECT username, password FROM Admin
);

# Merge all categories associated with each resource into JSON array. Join into edit_rows and search_rows views.
CREATE VIEW category_grouped AS (
	SELECT resource_id, JSON_ARRAYAGG(name) AS 'categories' FROM Category GROUP BY resource_id
);

# Merge all services associated with each resource into JSON array. Join into edit_rows and search_rows views.
CREATE VIEW service_grouped AS (
	SELECT resource_id, JSON_ARRAYAGG(name) AS 'services' FROM Service GROUP BY resource_id
);

# Create JSON objects from each field of a contact. Will be merged into array in contact_grouped view.
CREATE VIEW contact_objects AS (
	# TODO: Query to merge all data from each contact into its own JSON object.
)

# Merge all contact JSON objects into JSON array. Will be joined into data row views. 
CREATE VIEW contact_grouped AS (
	# TODO: Query to merge all contact json objects into grouped json array.
);

# Merge Updates and Admin tables to be used to merge into edit_row view
CREATE VIEW updates_w_admin AS (
	SELECT Updates.admin_id, Updates.lastUpdate,  Admin.username FROM Updates
		JOIN Admin ON Updates.admin_id=Admin.admin_id
);

##########################
### Data Display Views ###

# View for Resource Editor app, must have all data associated with each row
CREATE VIEW edit_rows AS (
	SELECT * FROM Resource ORDER BY name
		JOIN category_grouped ON Resource.resource_id=category_grouped.resource_id 
		JOIN service_grouped ON Resource.resource_id=service_grouped.resource_id
		# TODO: Join contact_grouped table
);

# View for Search Page app, must have all data associated with each row except for the username of the  admin who updated the document.
CREATE VIEW search_rows AS (
	SELECT name, street, zipcode, phone, email, website, description,
		requirements, documents, insurance, opHours  FROM Resource ORDER BY name 
		JOIN category_grouped ON Resource.resource_id=category_grouped.resource_id 
		JOIN service_grouped ON Resource.resource_id=service_grouped.resource_id 
		JOIN Updates ON Resource.resource_id=Updates.resource_id
		# TODO: Join contact_grouped table
);
