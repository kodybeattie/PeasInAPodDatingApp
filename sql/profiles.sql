
-- DROP'ping tables clear out any existing data
DROP TABLE IF EXISTS profiles;

-- CREATE the table
CREATE TABLE profiles(
	user_id VARCHAR(20) REFERENCES users(user_id),
	gender SMALLINT NOT NULL REFERENCES gender(value),
	gender_sought SMALLINT NOT NULL REFERENCES gender_sought(value),
	city INTEGER NOT NULL REFERENCES city(value),
	headline VARCHAR(100) NOT NULL,
	self_description VARCHAR(1000) NOT NULL,
	match_description VARCHAR(1000) NOT NULL,
	height INTEGER NOT NULL DEFAULT '0' REFERENCES height(value),
	images SMALLINT NOT NULL DEFAULT '0',
	body_type INTEGER NOT NULL DEFAULT '0' REFERENCES body_type(value),
	have_kids INTEGER NOT NULL DEFAULT '0' REFERENCES have_kids(value),
	smokes INTEGER NOT NULL DEFAULT '0' REFERENCES smokes(value),
	drinks INTEGER NOT NULL DEFAULT '0' REFERENCES drinks(value),
	pets INTEGER NOT NULL DEFAULT '0' REFERENCES pets(value),
	has_vehicle INTEGER NOT NULL DEFAULT '0' REFERENCES has_vehicle(value),
	want_kids INTEGER NOT NULL DEFAULT '0' REFERENCES want_kids(value),
	religion INTEGER NOT NULL DEFAULT '0' REFERENCES religion(value)
);
	