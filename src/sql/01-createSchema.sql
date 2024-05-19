
DROP SCHEMA IF EXISTS `oc_db`;
CREATE SCHEMA `oc_db`;
use `oc_db`; # Specify the database schema to place tables;


# Resource Table
CREATE TABLE IF NOT EXISTS `resource`(
	resource_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT UNIQUE,
	title VARCHAR(200) NOT NULL UNIQUE,
	email VARCHAR(200),
	opHours VARCHAR(350) NOT NULL,
	street_Address VARCHAR(100) NOT NULL,
	zipcode INT NOT NULL,
	phone VARCHAR(20) NOT NULL,
	website VARCHAR(200),
	description VARCHAR(500) NOT NULL,
	documents VARCHAR (500),
	requirements VARCHAR (500),
	insurance BOOLEAN NOT NULL
);


# Category Table
CREATE TABLE IF NOT EXISTS `category`(
	category_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT UNIQUE,
	name VARCHAR(100)NOT NULL UNIQUE,
	description VARCHAR(500) NOT NULL
);


# Belongs_to Table
CREATE TABLE IF NOT EXISTS `belongs_to`(
	resource_id INT PRIMARY KEY NOT NULL,
	category_id INT NOT NULL,
	FOREIGN KEY(category_id) REFERENCES category(category_id) ON DELETE CASCADE ON UPDATE CASCADE
);


# Contact Table
CREATE TABLE IF NOT EXISTS `contact`(
	contact_id INT NOT NULL AUTO_INCREMENT UNIQUE,
	resource_id INT NOT NULL,
	title VARCHAR(50) NOT NULL,
	f_Name VARCHAR(50) NOT NULL,
	l_Name VARCHAR(50) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	email VARCHAR(200),
	PRIMARY KEY(contact_id, resource_id),
	FOREIGN KEY(resource_id) REFERENCES resource(resource_id) ON DELETE CASCADE ON UPDATE CASCADE
);


# Admin Table
CREATE TABLE IF NOT EXISTS `admin`(
	admin_id INT NOT NULL AUTO_INCREMENT UNIQUE,
	username VARCHAR(20) NOT NULL UNIQUE,
	password VARCHAR(100) NOT NULL,
	f_Name VARCHAR(50) NOT NULL,
	l_Name VARCHAR(50) NOT NULL,
	PRIMARY KEY(admin_id)
);


# Service Table
CREATE TABLE IF NOT EXISTS `service`(
	service_id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
	name VARCHAR (100) NOT NULL UNIQUE,
	description VARCHAR(255) NOT NULL
);


# Updates Table
CREATE TABLE IF NOT EXISTS `updates`(
	PRIMARY KEY(resource_id, admin_id),
	FOREIGN KEY(resource_id) REFERENCES resource(resource_id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(admin_id) REFERENCES `admin`(admin_id) ON UPDATE CASCADE ON DELETE CASCADE,
	date DATE NOT NULL,
	admin_id INT NOT NULL,
	resource_id INT NOT NULL UNIQUE
);


# Provides Table
CREATE TABLE IF NOT EXISTS `provides`(
	resource_id INT NOT NULL,
	service_id INT PRIMARY KEY NOT NULL,
	FOREIGN KEY(resource_id) REFERENCES resource(resource_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(service_id) REFERENCES service(service_id) ON DELETE CASCADE ON UPDATE CASCADE
);
