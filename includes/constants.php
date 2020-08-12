<!-- 
Group: Group 05
File Name:constants.php
Date Modified: 2017-11-24
Course: WEBD3201
Description: A page that contains all of the
			constant values that will be used
			within the website.
-->
<?php
# ---------USER TYPES---------------
define("ADMIN","A");
define("CLIENT","C");
define("INCOMPLETE","I");
define("DISABLED","D");

#----------DATABASE CONNECTIONS----------------
define("HOST","127.0.0.1");
define("DB_NAME","group05_db");
define("OWNER","group05_admin");
define("PASSWORD","password");

define("MAX_USERS_PER_PAGE", 10);
define("MAX_RECORDS_RETRIEVED", 200);

define("USERNAME_LENGTH_MIN", 6);
define("USERNAME_LENGTH_MAX", 20);

define("PASSWORD_LENGTH_MIN", 6);
define("PASSWORD_LENGTH_MAX", 8);

define("MIN_REGISTER_AGE", 18);

define("MAX_NUMBER_OF_IMAGES", 7);

define("MAX_FILE_SIZE",100000);

define("SECONDS", 86400);
define("DAYS", 30);

define("STATUS_OPEN", "O");
define("STATUS_CLOSED", "C");
?>