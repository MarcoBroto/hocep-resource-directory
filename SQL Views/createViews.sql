
-- Get list of names of all available categories. Used for front-end selection menus.
CREATE VIEW category_list AS (
	SELECT name FROM Category ORDER BY name
);

-- Get list of names of all available services. Used for front-end selection menus. 
CREATE VIEW service_list AS (
	SELECT name FROM Service ORDER BY name
);

-- Merge all categories associated with each resource into JSON array. Join into edit_rows and search_rows views.
CREATE VIEW category_grouped AS (
	SELECT resource_id, JSON_ARRAYAGG(name) AS 'categories' FROM Category GROUP BY resource_id
);

-- Merge all services associated with each resource into JSON array. Join into edit_rows and search_rows views.
CREATE VIEW service_grouped AS (
	SELECT resource_id, JSON_ARRAYAGG(name) AS 'services' FROM Service GROUP BY resource_id
);

-- Merge Updates and Admin tables to be used to merge into edit_row view
CREATE VIEW updates_w_admin AS (
	SELECT Updates.admin_id, Updates.lastUpdate,  Admin.username FROM Updates
		JOIN Admin ON Updates.admin_id=Admin.admin_id
);

-- View for Resource Editor app, must have all data associated with each row
CREATE VIEW edit_rows AS (
	SELECT * FROM Resource ORDER BY name
		JOIN category_grouped ON Resource.resource_id=category_grouped.resource_id 
		JOIN service_grouped ON Resource.resource_id=service_grouped.resource_id
);

-- View for Search Page app, must have all data associated with each row except for the username of the  admin who updated the document.
CREATE VIEW search_rows AS (
	SELECT name, street, zipcode, phone, email, website, description,
		requirements, documents, insurance, opHours  FROM Resource ORDER BY name 
		JOIN category_grouped ON Resource.resource_id=category_grouped.resource_id 
		JOIN service_grouped ON Resource.resource_id=service_grouped.resource_id 
		JOIN Updates ON Resource.resource_id=Updates.resource_id
);
