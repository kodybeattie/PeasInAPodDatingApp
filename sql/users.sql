
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS users;

-- CREATE the table
CREATE TABLE users(
	user_id CHAR(20) PRIMARY KEY,
	password CHAR(32) NOT NULL,
	user_type CHAR(2) NOT NULL,
	email_address CHAR(255) NOT NULL,
	first_name CHAR (128) NOT NULL,
	last_name CHAR(128) NOT NULL,
	birth_date DATE,
	enrol_date DATE,
	last_accessed DATE
);

INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name, birth_date, enrol_date, last_accessed) 
VALUES(
	'millert',
	'c73e74706ceb79250e304347f76f364d',
	'A',
	'taylorwmiller@gmail.com',
	'Taylor',
	'Miller',
	'1993,07,29',
	'2017,09,27',
	'2017,09,27');
	
INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name, birth_date, enrol_date, last_accessed) 
VALUES(
	'Philbert',
	'930aa4c2824e19df3b5e57bd35cb2941',
	'I',
	'philroberts@hotmail.ca',
	'Philip',
	'Roberts',
	'1980,05,25',
	'2017,09,27',
	'2017,09,27');
	
INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name, birth_date, enrol_date, last_accessed) 
VALUES(
	'steve27',
	'8acef274195a5cd649d334465532c7de',
	'I',
	'steveharper@hotmail.ca',
	'Steven',
	'Harper',
	'1988,02,29',
	'2017,09,27',
	'2017,09,27');
	
INSERT INTO users(user_id, password, user_type, email_address, first_name, last_name, birth_date, enrol_date, last_accessed) 
VALUES(
	'Sara',
	'5bd537fc3789b5482e4936968f0fde95',
	'I',
	'sara@sara.com',
	'Sara',
	'Daly',
	'1995,08,12',
	'2017,09,27',
	'2017,09,27');	

--ORDER BY birth_date.year ASC;