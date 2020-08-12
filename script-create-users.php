<?php

include('../includes/constants.php');
include('../includes/db.php');
include('../includes/functions.php');
include('names.php');

function getRandomDay();
{
	return (mt_rand(1,31));
}

function getRandomMonth()
{
	return (mt_rand(1,12));
}

function getRandomYear()
{
	return (mt_rand(1900,2020));
}

function getRandomArrayIndex($givenArray)
{
	$lastIndex = ((sizeof($givenArray))-1);
	return (mt_rand(0,$lastIndex));
}

function getFirstName($gender)
{
	if($gender == "Male")
	{
		$names = getMaleNames();
	}	
	elseif($gender == "Female")
	{
		$names = getFemaleNames();
	}
	elseif ($gender == "Other")
	{
		$maleNames = getMaleNames();
		$femaleNames = getFemaleNames();
		$names = array_merge($maleNames, $femaleNames);
	}
	
	$index = getRandomArrayIndex($names);
	return ($names[$index]);
}

function getLastName()
{
	$lastNames = getLastNames();
	$index = getRandomArrayIndex($lastNames);
	return ($lastNames[$index]);
}

function getMaxValue($tableName)
{
	$sql = "SELECT * FROM '$tableName'";
	$result = pg_query($conn, $sql);
	$records = pg_fetch_all($result);
	$lastIndex = ((sizeof($records))-1);
	$maxValue = $records[$lastIndex]['value'];
	return $maxValue;
}

function getRandomTableProperty($tableName)
{
	$maxValue = getMaxValue($tableName);
	$randomValue = (mt_rand(1, $max_value));
	return (getProperty($tableName, $randomValue));
}

function getRandomEmail($userId, $firstName, $lastName)
{
	$leftSide = array($userId, $firstName, $lastName);
	$rightSide = array("hotmail", "outlook", "sympatico", "AOL");
	$leftPrompt1 = $leftSide[(mt_rand(0,2))];
	$leftPrompt2 = $leftSide[(mt_rand(0,2))];
	$rightSidePrompt = $rightSide[(mt_rand(0,3))];
	$email = $leftSidePrompt1 . $leftSidePrompt . "@" . $rightSidePrompt . ".ca";
	return $email;
}

function getRandomUserType();
{
	$userTypes = array(INCOMPLETE, CLIENT, ADMIN, DISABLED);
	$index = mt_rand(0,3);
	return ($userTypes[$index]);
}

function getRandomString($minNumberOfChars, $maxNumberOfChars)
{
	$randomString = "";
	$chars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','1','2','3','4','5','6','7','8','9','!','#','$','%','*','&');
	$numberOfCharacters = mt_rand($minNumberOfChars, $maxNumberOfChars);
	while(strlen($randomString) != $numberOfCharacters)
	{
		$char = $chars[(mt_rand(0,((sizeof($chars))-1)))];
		$randomString .= $char;
	}
	
	return ($randomString); 
}

$conn = db_connect();

if ($conn == false)
{
	echo "Can't connect to database.";
}
else
{
	for($totalUsers=0; $totalUsers <= 1000; $totalUsers++)
	{
		$userType = getRandomUserType();
		$userId = getRandomString(6,20);
		$password = md5(getRandomString(6,8));
		do
		{
			$birthDay = getRandomDay();
			$birthMonth = getRandomMonth();
			$birthYear = getRandomYear();
			$birthDate = ($birthYear . "," . $birthMonth . "," . $birthDay);
		}while(calculateAge($birthDate) < 18);
		
		do
		{
			$enrolDay = getRandomDay();
			$enrolMonth = getRandomMonth();
			$enrolYear = getRandomYear();
			$enrolDate = ($enrolYear . "," $enrolMonth . "," . $enrolDay);
		}while(strtotime($enrolDate < strtotime($birthDate)));
		
		do
		{
			$lastAccessedDay = getRandomDay();
			$lastAccessedMonth = getRandomMonth();
			$lastAccessedYear = getRandomYear();
			$lastAccessedDate = ($lastAccessedYear . "," . $lastAccessedMonth . "," . $lastAccessedDay);
		}while(strtotime($enrolDate > strtotime($lastAccessedDate)));
		
		if($userType == INCOMPLETE)
		{
			$firstName = getFirstName("Other");
		}
		else
		{
			$gender = getRandomTableProperty("gender");
			$firstName = getFirstName($gender);
			
			$genderSought = getRandomTableProperty("gender_sought");
			$city = getRandomTableProperty("city");
			$height = getRandomTableProperty("height");
			$bodyType = getRandomTableProperty("body_type");
			$haveKids = getRandomTableProperty("have_kids");
			$smokes = getRandomTableProperty("smokes");
			$drinks = getRandomTableProperty("drinks");
			$pets = getRandomTableProperty("pets");
			$hasVehicles = getRandomTableProperty("has_vehicle");
			$wantsKids = getRandomTableProperty("want_kids");
			$religion = getRandomTableProperty("religion");

		}

		$lastName = getLastName();
		$emailAddress = getRandomEmail($userId, $firstName, $lastName);
		
		$result = pg_execute($conn, "query_add_user", array($userId, $password, $userType, $emailAddress, $firstName, $lastName, $birthDate, $enrolDate, $lastAccessed));
		
		if($userType != INCOMPLETE)
		{
			$result = pg_execute($conn, "query_complete_profile", array($userId, $gender, $genderSought, $city, $height, $body_type, $have_kids, $smokes, $drinks, $pets, $has_vehicle, $want_kids, $religion));

		}
	}
}

?>