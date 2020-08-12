-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS interests;

-- CREATE the table
CREATE TABLE interests(
	user_id VARCHAR(20),
	liked_id VARCHAR(20),
	entry_made TIMESTAMP
);
	