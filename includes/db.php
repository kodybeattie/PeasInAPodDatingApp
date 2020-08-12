<!-- 
Group: Group 05
File Name:db.php
Date Modified: 2017-11-24
Course: WEBD3201
Description: A page that contains all of the
			database related work for this site.
-->
<?php

/*
Date Modified: 2017-09-17
Description: This is a function that acts as the intializer of 
			the connection between the database and the website.
*/
function db_connect()
{
	# create connection string
	$connection_string = "host=" . HOST . " dbname=" . DB_NAME . " user=" . OWNER . " password=" . PASSWORD;
	# connect to the database
	$conn = pg_connect($connection_string);
	return $conn;
}

$conn = db_connect(); # global database connection

# if the connection fails
if ($conn == false)
{
	# echo an error
	echo "Could not connect to the database.";
}
else
{
	# Add a user to the database
	$statement_query_add_user = pg_prepare($conn, "query_add_user", "INSERT INTO users (user_id, password, user_type, email_address, first_name, last_name, birth_date, enrol_date, last_accessed) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)");
	
	# Insert a new profile into the profiles table
	$statment_query_complete_profile = pg_prepare($conn, "query_complete_profile", "INSERT INTO profiles (user_id, gender, gender_sought, city, headline, self_description, match_description, height, body_type, have_kids, smokes, drinks, pets, has_vehicle, want_kids, religion) VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16)");
	
	# Update an existing profile
	$statment_query_update_profile = pg_prepare($conn, "query_update_profile", "UPDATE profiles SET gender = $1, gender_sought = $2, city = $3, headline = $4, self_description = $5, match_description = $6, height = $7, body_type = $8, have_kids = $9, smokes = $10, drinks = $11, pets = $12, has_vehicle = $13, want_kids = $14, religion = $15 WHERE user_id = $16");
	
	# Update an existing profile
	$statment_query_update_user = pg_prepare($conn, "query_update_user", "UPDATE users SET email_address = $2, first_name = $3, last_name = $4, birth_date = $5 WHERE user_id = $1");
	
	# Get a users information
	$statement_query_get_login = pg_prepare($conn, "query_get_login", "SELECT user_id, password, user_type, email_address, first_name, last_name, birth_date, last_accessed FROM users WHERE user_id = $1 AND password= $2");
	
	$statement_query_get_email = pg_prepare($conn, "query_get_email", "SELECT user_id, email_address FROM users WHERE user_id = $1");

	# Update the last time the user accessed the site
	$statement_query_update_last_access = pg_prepare($conn, "query_update_last_access", "UPDATE users SET last_accessed = $1 WHERE user_id = $2");
	
	# Update the type of user
	$statement_query_update_user_type = pg_prepare($conn, "query_update_user_type", "UPDATE users SET user_type = $1 WHERE user_id = $2");
	
	# Check if user id is in the database or not
	$statement_query_check_if_exist_userid = pg_prepare($conn, "query_check_if_exist_userid", "SELECT user_id FROM users WHERE user_id = $1");
	
	# Get a user's profile
	$statement_query_get_profile = pg_prepare($conn, "query_get_profile", "SELECT * FROM profiles WHERE user_id = $1");
	
	# Get a user
	$statement_query_get_user = pg_prepare($conn, "query_get_user", "SELECT * FROM users WHERE user_id = $1");

	# Get a user
	$statement_query_get_user_type = pg_prepare($conn, "query_get_user_type", "SELECT user_type FROM users WHERE user_id = $1");
	
	# Find users according to search criteria
	$statement_query_find_users = pg_prepare($conn, "query_find_users", "SELECT profiles.user_id FROM profiles,users WHERE profiles.gender_sought=$1 AND (profiles.height=ANY($2)) AND (profiles.body_type=ANY($3)) AND (profiles.city=ANY($4)) AND profiles.religion=$5 AND (profiles.has_vehicle=ANY($6)) AND (profiles.smokes=ANY($7)) AND (profiles.drinks=ANY($8)) AND (profiles.pets=ANY($9)) AND (profiles.have_kids=ANY($10)) AND (profiles.want_kids=ANY($11)) AND profiles.user_id = users.user_id  AND NOT users.user_type = 'D' ORDER BY users.last_accessed DESC LIMIT $12");

	#Change User Password
	$statment_query_change_user_password = pg_prepare($conn, "query_change_user_password", "UPDATE users SET password = $1 WHERE user_id = $2");

	$statment_query_update_user_images = pg_prepare($conn, "query_update_user_images", "UPDATE profiles SET images = $1 WHERE user_id = $2");
	
	# Get a users password
	$statement_query_get_user_password = pg_prepare($conn, "query_get_user_password", "SELECT password FROM users WHERE user_id = $1");
	
	$statement_query_find_interest = pg_prepare($conn, "query_find_interest", "SELECT user_id, liked_id FROM interests WHERE user_id =$1 AND liked_id=$2");
	
	$statement_query_find_user_interests = pg_prepare($conn, "query_find_user_interests", "SELECT liked_id FROM interests WHERE user_id=$1");
	
	$statement_query_find_other_interests = pg_prepare($conn, "query_find_other_interests", "SELECT user_id FROM interests WHERE liked_id=$1");
	
	$statement_query_insert_interest = pg_prepare($conn, "query_insert_interest", "INSERT INTO interests (user_id, liked_id) VALUES ($1,$2)");
	
	$statement_query_delete_interest = pg_prepare($conn, "query_delete_interest", "DELETE FROM interests WHERE user_id = $1 AND liked_id = $2");
	
	$statement_query_delete_disabled_interest = pg_prepare($conn, "query_delete_disabled_interest", "DELETE FROM interests WHERE user_id = $1 OR liked_id = $1");
	
	$statement_query_report_user = pg_prepare($conn, "query_report_user","INSERT INTO offensives (user_id_reported, user_id_reporting, status) VALUES ($1,$2,$3)");
	
	$statement_query_check_if_reported = pg_prepare($conn, "query_check_if_reported", "SELECT user_id_reported FROM offensives WHERE user_id_reported = $1");
	
	$statment_query_check_if_reporter_viewing = pg_prepare($conn, "query_check_if_reporter_viewing","SELECT user_id_reported, user_id_reporting FROM offensives WHERE user_id_reported = $1 AND user_id_reporting=$2");
	
	$statement_query_close_ticket = pg_prepare($conn, "query_update_ticket_status", "UPDATE offensives SET status = $1 WHERE user_id_reported = $2");

	/*
	Date Modified: 2017-11-26
	Description: This function builds a drop down menu
				based on a table name and the size of
				of the table with the values of said table
				as options to choose from.
	*/
	function buildDropDown($tableName, $maxValue)
	{
		# Intialize a build string
		$dropDown = "";
		$dropDown .= "<select name='$tableName'>";
		# Get a property based on the value from the table and add it as an option
		for($i=1; $i<=$maxValue;$i=$i*2)
		{
			$property = getProperty($tableName, $i);
			if (isset($_POST[$tableName]) && $_POST[$tableName] == $i || isset($_SESSION[$tableName]) && $_SESSION[$tableName] == $i)
			{
				$dropDown .= "<option value='$i' selected='selected'>$property</option>";
			}
			else
			{
				$dropDown .= "<option value='$i'>$property</option>";
			}
			
		}
		$dropDown .= "</select>";
		# echo the HTML
		echo $dropDown;

	}

	/*
	Date Created: 2017-11-26
	Description: This function builds radio buttons
				based on a table name and the size of
				of the table with the values of said table
				as options to choose from.
	*/
	function buildRadio($tableName, $maxValue)
	{	
		# For every value in the table grab the property and add it as a radio button option
		for($i=1; $i<=$maxValue;$i=$i*2)
		{
			$property = getProperty($tableName, $i);
			$check = 'checked = "checked"';
			#echo the html with variables inside
			if (isset($_POST[$tableName]) && $_POST[$tableName] == $i || isset($_SESSION[$tableName]) && $_SESSION[$tableName] == $i)
			{
				echo "<input id='$tableName' type='radio' name='$tableName' value='$i' checked='checked'>";
				echo "<label for='$tableName'>$property</label>";
			}
			else
			{
				echo "<input id='$tableName' type='radio' name='$tableName' value='$i'>";
				echo "<label for='$tableName'>$property</label>";
			}
		}
	}

	/*
	Date Created: 2017-12-04
	Description: This function builds a set of check boxes
				based on a table name and the size of
				of the table with the values of said table
				as options to choose from.
	*/
	function buildCheckBox($tableName, $prechecked)
	{	

		# For every value in the table grab the property and add it as a check box
		$conn = db_connect();
		$sql = "SELECT property, value FROM ".$tableName." WHERE value > 0";
		$result = pg_query($conn, $sql);
		
		for($i=0; $i< pg_num_rows($result);$i++)
		{
			$property = pg_fetch_result($result, $i, "property");
			$value = pg_fetch_result($result, $i, "value");
			if (isBitSet($i, $prechecked))
			{
				$checked = "checked =\"checked\"";
			}
			else
			{
				$checked = "";
			}
			echo "<input id='".$i."' type='checkbox' name='".$tableName."[]' value='".$value."' ". $checked . " />";
			echo "<label for='".$i."'>".$property."</label><br/>";
			
		}
	}

	/*
	Date Created: 2017-11-24
	Description: This function accesses a specific table and retrieves
				the property based on the value it is given.
	*/
	function getProperty($tableName, $value)
	{
		# Connect to the database
		$conn = db_connect();
		# create an sql statemnt
		$sql = "SELECT property FROM $tableName WHERE value = $value";
		# Query the database
		$result = pg_query($conn, $sql);
		# return the property
		$property = pg_fetch_result($result,0,'property');

		return $property;
	}
}
?>
