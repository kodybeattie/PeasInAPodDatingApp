-- CREATE the tables

DROP TABLE IF EXISTS profiles;
DROP TABLE IF EXISTS gender;
DROP TABLE IF EXISTS gender_sought;
DROP TABLE IF EXISTS height;
DROP TABLE IF EXISTS city;
DROP TABLE IF EXISTS body_type;
DROP TABLE IF EXISTS have_kids;
DROP TABLE IF EXISTS smokes;
DROP TABLE IF EXISTS drinks;
DROP TABLE IF EXISTS pets;
DROP TABLE IF EXISTS has_vehicle;
DROP TABLE IF EXISTS want_kids;
DROP TABLE IF EXISTS religion;

CREATE TABLE gender(
	value INTEGER PRIMARY KEY,
	property VARCHAR(6) NOT NULL
	);
	
INSERT INTO gender(value,property) 
VALUES(
	'1',
	'Male');
	
INSERT INTO gender(value,property) 
VALUES(
	'2',
	'Female');
	
INSERT INTO gender(value,property) 
VALUES(
	'4',
	'Other');
	
CREATE TABLE gender_sought(
	value INTEGER PRIMARY KEY,
	property VARCHAR(6) NOT NULL
	);
	
INSERT INTO gender_sought(value,property) 
VALUES(
	'1',
	'Male');
	
INSERT INTO gender_sought(value,property) 
VALUES(
	'2',
	'Female');

CREATE TABLE height(
	value INTEGER PRIMARY KEY,
	property VARCHAR(20) NOT NULL
	);

INSERT INTO height(value,property) 
VALUES(
	'1',
	'Doesnt Matter');
	
INSERT INTO height(value,property) 
VALUES(
	'2',
	'Under 4 Feet');

INSERT INTO height(value,property) 
VALUES(
	'4',
	'4Ft 3 Inches');

INSERT INTO height(value,property) 
VALUES(
	'8',
	'4Ft 6 Inches');

INSERT INTO height(value,property) 
VALUES(
	'16',
	'4Ft 9 Inches');

INSERT INTO height(value,property) 
VALUES(
	'32',
	'5Ft');

INSERT INTO height(value,property) 
VALUES(
	'64',
	'5Ft 3 Inches');

INSERT INTO height(value,property) 
VALUES(
	'128',
	'5Ft 6 inches');

INSERT INTO height(value,property) 
VALUES(
	'256',
	'5Ft 9 inches');

INSERT INTO height(value,property) 
VALUES(
	'512',
	'6Ft');

INSERT INTO height(value,property) 
VALUES(
	'1024',
	'6Ft 3 Inches');

INSERT INTO height(value,property) 
VALUES(
	'2048',
	'6Ft 6 Inches');

INSERT INTO height(value,property) 
VALUES(
	'4096',
	'6Ft 9 Inches');

INSERT INTO height(value,property) 
VALUES(
	'8192',
	'7Ft');

INSERT INTO height(value,property) 
VALUES(
	'16384',
	'Over 7Ft');

CREATE TABLE city(
	value INTEGER PRIMARY KEY,
	property VARCHAR(20) NOT NULL
	);
	
INSERT INTO city(value,property) 
VALUES(
	'1',
	'Ajax');
	
INSERT INTO city(value,property) 
VALUES(
	'2',
	'Brooklin');
	
INSERT INTO city(value,property) 
VALUES(
	'4',
	'Bowmanville');
	
INSERT INTO city(value,property) 
VALUES(
	'8',
	'Oshawa');

INSERT INTO city(value,property) 
VALUES(
	'16',
	'Pickering');

INSERT INTO city(value,property) 
VALUES(
	'32',
	'Port Perry');

INSERT INTO city(value,property) 
VALUES(
	'64',
	'Whitby');
	
CREATE TABLE body_type(
	value INTEGER PRIMARY KEY,
	property VARCHAR(15) NOT NULL
	);

INSERT INTO body_type(value,property) 
VALUES(
	'1',
	'Doesnt Matter');
	
INSERT INTO body_type(value,property) 
VALUES(
	'2',
	'Below Average');
	
INSERT INTO body_type(value,property) 
VALUES(
	'4',
	'Average');
	
INSERT INTO body_type(value,property) 
VALUES(
	'8',
	'Above Average');
	
CREATE TABLE have_kids(
	value INTEGER PRIMARY KEY,
	property VARCHAR(13) NOT NULL
	);

INSERT INTO have_kids(value,property) 
VALUES(
	'1',
	'Doesnt Matter');	

INSERT INTO have_kids(value,property) 
VALUES(
	'2',
	'Yes');
	
INSERT INTO have_kids(value,property) 
VALUES(
	'4',
	'No');
	
CREATE TABLE smokes(
	value INTEGER PRIMARY KEY,
	property VARCHAR(13) NOT NULL
	);

INSERT INTO smokes(value,property) 
VALUES(
	'1',
	'Doesnt Matter');
	
	
INSERT INTO smokes(value,property) 
VALUES(
	'2',
	'Yes');
	
INSERT INTO smokes(value,property) 
VALUES(
	'4',
	'No');
	
CREATE TABLE drinks(
	value INTEGER PRIMARY KEY,
	property VARCHAR(13) NOT NULL
	);

INSERT INTO drinks(value,property) 
VALUES(
	'1',
	'Doesnt Matter');
	
INSERT INTO drinks(value,property) 
VALUES(
	'2',
	'Yes');
	
INSERT INTO drinks(value,property) 
VALUES(
	'4',
	'No');
	
CREATE TABLE pets(
	value INTEGER PRIMARY KEY,
	property VARCHAR(13) NOT NULL
	);

INSERT INTO pets(value,property) 
VALUES(
	'1',
	'Doesnt Matter');
	
INSERT INTO pets(value,property) 
VALUES(
	'2',
	'Yes');
	
INSERT INTO pets(value,property) 
VALUES(
	'4',
	'No');
	
CREATE TABLE has_vehicle(
	value INTEGER PRIMARY KEY,
	property VARCHAR(13) NOT NULL
	);

INSERT INTO has_vehicle(value,property) 
VALUES(
	'1',
	'Doesnt Matter');
	
INSERT INTO has_vehicle(value,property) 
VALUES(
	'2',
	'Yes');
	
INSERT INTO has_vehicle(value,property) 
VALUES(
	'4',
	'No');

CREATE TABLE want_kids(
	value INTEGER PRIMARY KEY,
	property VARCHAR(13) NOT NULL
	);

INSERT INTO want_kids(value,property) 
VALUES(
	'1',
	'Doesnt Matter');
	
INSERT INTO want_kids(value,property) 
VALUES(
	'2',
	'Yes');
	
INSERT INTO want_kids(value,property) 
VALUES(
	'4',
	'No');
	
CREATE TABLE religion(
	value INTEGER PRIMARY KEY,
	property VARCHAR(15) NOT NULL
	);
	
INSERT INTO religion(value,property) 
VALUES(
	'1',
	'Atheist');
	
INSERT INTO religion(value,property) 
VALUES(
	'2',
	'Buddhist');
	
INSERT INTO religion(value,property) 
VALUES(
	'4',
	'Christian');
	
INSERT INTO religion(value,property) 
VALUES(
	'8',
	'Hindu');
	
INSERT INTO religion(value,property) 
VALUES(
	'16',
	'Jewish');
	
INSERT INTO religion(value,property) 
VALUES(
	'32',
	'Muslim');
	
INSERT INTO religion(value,property) 
VALUES(
	'64',
	'Other');