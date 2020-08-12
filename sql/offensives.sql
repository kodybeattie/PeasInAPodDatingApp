-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS offensives;

-- CREATE the table
CREATE TABLE offensives(
	user_id_reported CHAR(20) NOT NULL,
	user_id_reporting CHAR(20) NOT NULL,
	status CHAR(1) NOT NULL,
	entry_made TIMESTAMP
);
