<?php
/*
Name: Group 05
File: seed-database.php
Date: 2017-09-29
Description : The login page.
Course: Webd3201
*/
$title = "Seed";
$banner ="Returning member?";
$description ="This is where the user can log in";
$filename = "user-login.php";
$test = "Login";
include("header.php");
include("scripts/names.php");

$error = ""; # contains the error message string

if($_SERVER["REQUEST_METHOD"] == "GET"){



}else if($_SERVER["REQUEST_METHOD"] == "POST"){

	function getRandomDay()
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
		$firstNameOut = "";
		if($gender == 1)
		{
			$names = getMaleNames();
			$index = getRandomArrayIndex($names);
			$firstNameOut = $names[$index];
		}	
		elseif($gender == 2)
		{
			$names = getFemaleNames();
			$index = getRandomArrayIndex($names);
			$firstNameOut = $names[$index];
		}
		elseif ($gender == 4)
		{
			$maleNames = getMaleNames();
			$femaleNames = getFemaleNames();
			$names = array_merge($maleNames, $femaleNames);
			$index = getRandomArrayIndex($names);
			$firstNameOut = $names[$index];
		}

		return $firstNameOut;
	}

	function getLastName()
	{
		$lastNames = getLastNames();
		$index = getRandomArrayIndex($lastNames);
		return ($lastNames[$index]);
	}

	function getRandomTableProperty($tableName)
	{
		$conn = db_connect();
		$sql = "SELECT * FROM $tableName";
		$result = pg_query($conn, $sql);
		$numRecords = pg_num_rows($result);
		$records = pg_fetch_all($result);
		$exponent = (mt_rand(0, ($numRecords - 1)));
		$randomValue = pow(2,$exponent);
		return $randomValue;
	}

	function getRandomEmail($userId, $firstName, $lastName)
	{
		$leftSide = array($userId, $firstName, $lastName);
		$rightSide = array("hotmail", "outlook", "sympatico", "AOL");
		$leftPrompt1 = $leftSide[(mt_rand(0,2))];
		$leftPrompt2 = $leftSide[(mt_rand(0,2))];
		$rightSidePrompt = $rightSide[(mt_rand(0,3))];
		$email = $leftPrompt1 . $leftPrompt2 . "@" . $rightSidePrompt . ".ca";
		return $email;
	}

	function getRandomUserType()
	{
		$userTypes = array(INCOMPLETE, CLIENT, ADMIN, DISABLED);
		$index = mt_rand(0,3);
		return ($userTypes[$index]);
	}
	
	function getHeadline()
	{
		$headlines = array("Hi","Hey","What's up?","Probably like your dog more.","Let's have fun","No mean people please");
		$index = getRandomArrayIndex($headlines);
		$userHeadline = $headlines[$index];
		return $userHeadline;
	}
	
	function getMatchDescription()
	{
		$sentence1 = array("Looking for someone who loves kids.","Looking for a hard working partner.","Looking for a romantic.","Looking for a fun lover.");
		$sentence2 = array("Toned body is a plus.","Be nice and sincere.","Someone who enjoys lazing around every once in a while.","Someone who can handle their alcohol.");
		$index1 = getRandomArrayIndex($sentence1);
		$index2 = getRandomArrayIndex($sentence2);
		$matchDescription = $sentence1[$index1] . $sentence2[$index2];
		return $matchDescription;
	}
	
	function getSelfDescription()
	{
		$sentence1 = array("I am a party animal.","Workaholic.","All I do is sleep and lay on the couch.","My kids are my world.");
		$sentence2 = array("I like to spend my Tuesday nights on Netflix.","I can bake a mean pie.","I love browsing reddit.","I'm a Liberal.");
		$index1 = getRandomArrayIndex($sentence1);
		$index2 = getRandomArrayIndex($sentence2);
		$userDescription = $sentence1[$index1] . $sentence2[$index2];
		return $userDescription;
	}
	
	$conn = db_connect();

	if ($conn == false)
	{
		echo "Can't connect to database.";
	}
	else
	{
		for($totalUsers=0; $totalUsers <= 500; $totalUsers++)
		{
			$userType = getRandomUserType();
			$userId = getRandomString(6,20);
			$password = md5(getRandomString(6,8));
			do
			{
				$birthDay = getRandomDay();
				$birthMonth = getRandomMonth();
				$birthYear = getRandomYear();
				$birthDate = ($birthYear . "-" . $birthMonth . "-" . $birthDay);
			}while((calculateAge($birthDate) < 18) || (!checkdate($birthMonth,$birthDay,$birthYear)));
			
			do
			{
				$enrolDay = getRandomDay();
				$enrolMonth = getRandomMonth();
				$enrolYear = getRandomYear();
				$enrolDate = ($enrolYear . "-" . $enrolMonth . "-" . $enrolDay);
			}while((strtotime($enrolDate) < strtotime($birthDate)) || (!checkdate($enrolMonth,$enrolDay,$enrolYear)));
			
			do
			{
				$lastAccessedDay = getRandomDay();
				$lastAccessedMonth = getRandomMonth();
				$lastAccessedYear = getRandomYear();
				$lastAccessedDate = ($lastAccessedYear . "-" . $lastAccessedMonth . "-" . $lastAccessedDay);
			}while((strtotime($enrolDate) > strtotime($lastAccessedDate)) || (!checkdate($lastAccessedMonth,$lastAccessedDay,$lastAccessedYear)));
			
			if(trim($userType) == INCOMPLETE)
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
				$hasVehicle = getRandomTableProperty("has_vehicle");
				$wantsKids = getRandomTableProperty("want_kids");
				$religion = getRandomTableProperty("religion");

			}

			$lastName = getLastName();
			$emailAddress = getRandomEmail($userId, $firstName, $lastName);
			$headline = getHeadline();
			$selfDescription = getSelfDescription();
			$matchDescription = getMatchDescription();
			
			$result = pg_execute($conn, "query_add_user", array($userId, $password, $userType, $emailAddress, $firstName, $lastName, $birthDate, $enrolDate, $lastAccessedDate));
			
			if($userType != INCOMPLETE)
			{
				$result = pg_execute($conn, "query_complete_profile", array($userId, $gender, $genderSought, $city, $headline, $selfDescription, $matchDescription, $height, $bodyType, $haveKids, $smokes, $drinks, $pets, $hasVehicle, $wantsKids, $religion));

			}
		}
	}
}
?>

<!-- One -->
<section id="one" class="wrapper">
	<div class="inner">
		<div class="flex flex-3">
			<article>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div>
							<input type="submit" value = "Seed Database" class="special"/>
						</div>
					</form>
			</article>
		</div>
	</div>
</section>

<!-- Footer -->
<?php include("footer.php") ?>