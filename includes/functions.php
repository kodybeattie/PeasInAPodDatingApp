<!-- 
Group: Group 05
File Name:functions.php
Date Modified: 2017-11-24
Course: WEBD3201
Description: A page that contains some of the functions
			that are used within the site that have no
			real category.
-->
<?php
	/*
	Date created: 2017-11-24
	Description: This is a function that displays copyright info for the website.
	*/
	function displayCopyrightInfo()
	{
		# string contains copyright symbol. current date, and company name
		$copyrightLine = ("&copy;" . " " . date('Y') . " " . "Peas In a Pod");
		return $copyrightLine;
	}

	/*
	Date modified: 2017-11-26
	Description: Calculates the age of a person based on the current year
				and their birthday.
	*/
	
	function calculateAge($birthDateGiven)
	{
		# Get today's date in long form
		$today = new DateTime();
		# Get the difference between todays date and users birthday
		$userBirth = new DateTime($birthDateGiven);
		$diff = date_diff($userBirth, $today);
		# return the difference in year format
		$age = ((int)($diff->format('%y')));
		return $age;
	}
	
	/*
	Date modified: 2017-11-24
	Description: Displays certain links if the user is logged in.
	*/
	function loadLoggedInUserLinks()
	{
		echo'<a href="user-dashboard.php">User Dashboard</a>';
		echo'<a href="profile-display.php">My Profile</a>';
		echo'<a href="interests.php">Interests</a>';
		echo'<a href="user-update.php">Update Info</a>';
		echo'<a href="profile-create.php">Update Profile</a>';
		echo'<a href="user-password-change.php">Change Password</a>';
		echo'<a href="user-logout.php">Log Out</a>';
		displayIfSearchResults();
	}
	
		/*
	Date modified: 2017-11-26
	Description: Displays certain links if the user isn't logged in but incomplete.
	*/
	function loadLoggedInAdminLinks()
	{
		echo'<a href="admin.php">Admin Page</a>';
		echo'<a href="profile-create.php">Update Profile</a>';
		echo'<a href="interests.php">Interests</a>';
		echo'<a href="user-update.php">Update Info</a>';
		echo'<a href="user-password-change.php">Change Password</a>';
		echo'<a href="disabled-users.php">Disabled Users</a>';
		echo'<a href="user-logout.php">Log Out</a>';
		displayIfSearchResults();
	}
	
	/*
	Date modified: 2017-11-26
	Description: Displays certain links if the user isn't logged in but incomplete.
	*/
	function loadLoggedInIncompleteUserLinks()
	{
		echo'<a href="user-dashboard.php">User Dashboard</a>';
		echo'<a href="profile-create.php">Create Profile</a>';
		echo'<a href="user-update.php">Update Info</a>';
		echo'<a href="user-password-change.php">Change Password</a>';
		echo'<a href="user-logout.php">Log Out</a>';
		displayIfSearchResults();
	}
	
	/*
	Date modified: 2017-11-24
	Description: Displays certain links if the user isn't logged in.
	*/
	function loadLoggedOutUserLinks()
	{
		echo'<a href="user-register.php">User Registration</a>';
		echo'<a href="user-password-request.php">Request Password</a>';
		echo'<a href="user-login.php">Log In</a>';

	}
	
	function createProfilePreview($userId)
	{
		$conn = db_connect();
		$result = pg_execute($conn, "query_get_profile", array($userId));
		if(pg_num_rows($result)==0)
		{
			$output = "<a href=./profile-display.php?displayId=".$userId.">".$userId."</a>";
		}
		else
		{
			$city = pg_fetch_result($result,0,'city');
			$output = "<a href=./profile-display.php?displayId=".$userId.">".$userId."</a>". " " . getProperty('city',$city);
		}
	
	?>	
		<img src="<?php echo "images/".$userId."/".$userId."_1.jpg";?>" alt="Image" height="40px" width="40px"/>
	<?php
		echo $output . "</br>";
	}
	
	function displayIfSearchResults()
	{
		if(isset($_SESSION['search_results']))
		{
			echo'<a href="profile-search-results.php">Profile Search Results</a>';
		}
	}
	
	/*
	*/
	function isBitSet($power, $decimal)
	{
		if((pow(2,$power)) & ($decimal))
		{
			return 1;
		}
		else
			return 0;
	}
	
	/*
	*/
	function sumCheckBox($array)
	{
		$num_checks = count($array);
		$sum = 0;
		for($i = 0; $i < $num_checks; $i++)
		{
			$sum += $array[$i];
		}
		return $sum;
	}
	
	function getCities($checkBoxSum)
	{
		$cityValues = array();
		for($exp = 7; $exp >= 0; $exp--)
		{
			if(isBitSet($exp, $checkBoxSum))
			{
				array_push($cityValues, (int)(pow(2,$exp)));
			}
			$checkBoxSum -= pow(2, $exp);
		}
		return $cityValues;
	}
	
	function createSqlUsableArray($list)
	{
		$returnList ="{";
		for($i=0;$i < count($list);$i++)
		{
			if(($i + 1) == count($list))
			{
				$returnList .= $list[$i];
			}
			else
			{
				$returnList .= $list[$i].",";
			}
		}
		$returnList.="}";
		return $returnList;
	}
	
	function getRandomString($minNumberOfChars, $maxNumberOfChars)
	{
		$randomString = "";
		$chars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','1','2','3','4','5','6','7','8','9');
		$numberOfCharacters = mt_rand($minNumberOfChars, $maxNumberOfChars);
		while(strlen($randomString) != $numberOfCharacters)
		{
			$char = $chars[(mt_rand(0,((sizeof($chars))-1)))];
			$randomString .= $char;
		}
		
		return ($randomString); 
	}
	
	function getRandomNum($minNumberOfChars, $maxNumberOfChars)
	{
		$randomString = "";
		$chars = array('1','2','3','4','5','6','7','8','9');
		$numberOfCharacters = mt_rand($minNumberOfChars, $maxNumberOfChars);
		while(strlen($randomString) != $numberOfCharacters)
		{
			$char = $chars[(mt_rand(0,((sizeof($chars))-1)))];
			$randomString .= $char;
		}
		
		return ($randomString); 
	}
?>
