<?php
/*
Filename: user-register.php
Group: Group 05
Date: 2017-11-24
Course:WEBD3201
*/

$title ="Register";
$banner ="Register";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
			
include "header.php"; # bring in the header file containing a nav bar, description, heading
$error = "";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	$loginId = ""; # users login id
	$password = ""; #users password
	$confirmPassword = ""; # used to confirm users password
	$emailAddress = ""; # users email address
	$isValidEmail = false; # used to confirm if user email is valid address
	$firstName = ""; # users first name
	$lastName = ""; # users last name
	$enrolDate =""; # users enrol date 
	$birthDate =""; # users birth date
	
}else if($_SERVER["REQUEST_METHOD"] == "POST"){
	# pull info from the post array
	$loginId = trim($_POST["txtInputUsername"]);
	$password = trim($_POST["txtInputPassword"]);
	$confirmPassword = trim($_POST["txtInputConfirmPassword"]);
	$emailAddress = trim($_POST["txtInputEmail"]);
	$firstName = trim($_POST["txtInputFirstName"]);
	$lastName = trim($_POST["txtInputLastName"]);
	$birthDay = ($_POST["birthDay"]);
	$birthMonth = ($_POST["birthMonth"]);
	$birthYear = ($_POST["birthYear"]);
	
	#create bithdate string
	$birthDate= $birthYear . "-" . $birthMonth . "-" . $birthDay;
	# get todays date for enrol date
	$enrolDate = date('Ymd');
	# set current day as the last access day
	$lastAccessed = $enrolDate;
	

	$conn = db_connect(); # connect to database
	
	# if connection fails
	if ($conn == false)
	{
		$error .= "Could not connect to database.";
	}
	else
	{
		# validate login id
		if ($loginId == "" || strlen($loginId) < USERNAME_LENGTH_MIN || strlen($loginId) > USERNAME_LENGTH_MAX)
		{
			$error .= "Please enter a username that is at least 6 but not more than 20 characters long.";
		}
		
		# check to ensure login id doesnt already exist
		$result = pg_execute($conn, "query_check_if_exist_userid", array($loginId));
		if (pg_num_rows($result) > 0)
		{
			$error .= "Username already exists. Please create a new one.";
		}
	
		# validate password
		if ($password == "" || strlen($password) < PASSWORD_LENGTH_MIN || strlen($password) > PASSWORD_LENGTH_MAX)
		{
			$error .= "Please enter a password that is at least 6 or at most 8 characters long.";
		}
		
		# ensure password and confirmed password are the same
		if ($password != $confirmPassword)
		{
			$error .= "Your passwords did not match, please enter them again.";
		}
		
		# confirm email is a valid address
		$isValidEmail = FILTER_VAR($emailAddress, FILTER_VALIDATE_EMAIL);
		if ($isValidEmail == false)
		{
			$error .= "Email address is invalid. Please enter valid email address.";
		}
		
		# ensure first name is entered
		if ($firstName == "")
		{
			$error .= "Please enter your first name. For business purposes.";
		}
		
		#ensure last name is entered
		if ($lastName == "")
		{
			$error .= "Please enter your last name. For business purposes.";
		}
		
		# calculate the users age ensure they are over 18
		if (calculateAge($birthDate) < MIN_REGISTER_AGE)
		{
			$error .= "You must be at least 18 to register for our site, sorry.";
		}
		
		# if there were no errors
		if (strlen($error) == 0)
		{
			$password = md5($password);
			# add the user to the users table
			$result = pg_execute($conn, "query_add_user", array($loginId, $password, INCOMPLETE, $emailAddress, $firstName, $lastName, $birthDate, $enrolDate, $lastAccessed));
			# get login information of user
			$result = pg_execute($conn, "query_get_login", array($loginId, $password));
			$row = pg_fetch_assoc($result);
			# add user login info to the session
			foreach ($row as $key => $value)
			{
				$_SESSION[$key] = $value;
			}
			$_SESSION['loggedIn'] = true;
			# check that user was added to database
			$result = pg_execute($conn, "query_check_if_exist_userid", array($loginId));
			if (pg_num_rows($result) > 0)
			{
				# send user to profile creat page
				header('Refresh:3; url=profile-create.php');
				echo "You've been added to our system! Let's create your profile!";
			}
		}
	}
}

?>


<section id="banner">
<h1>Register</h1>
<h3><?php echo $error; ?></h3>
</section>
<!-- The form used for input -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >

	<!--text boxes-->
	<table>

		<tr>
			<td><strong>Username</strong></td>
			<td><input type="text" name="txtInputUsername" value="<?php echo $loginId; ?>" size="20" /></td>
		</tr>
		
		<tr>
			<td><strong>Password</strong></td>
			<td><input type="password" name="txtInputPassword" value="" size="20" /></td>
		</tr>
		<tr>
			<td><strong>Confirm Password</strong></td>
			<td><input type="password" name="txtInputConfirmPassword" value="" size="20" /></td>
		</tr>
		
		<tr>
			<td><strong>Email Address</strong></td>
			<td><input type="text" name="txtInputEmail" value="<?php echo $emailAddress;?>" size="20" /></td>
		</tr>
		<tr>
			<td><strong>First Name</strong></td>
			<td><input type="text" name="txtInputFirstName" value="<?php echo $firstName; ?>" size="20" /></td>
		</tr>
		<tr>
			<td><strong>Last Name</strong></td>
			<td><input type="text" name="txtInputLastName" value="<?php echo $lastName; ?>" size="20" /></td>
		</tr>
	</table>
	
	<?php
		$allMonths = array("--Month--","January","February","March","April","May","June","July","August","September","October","November","December");
	?>
	
	<div>	
		<!--Get birth month-->
		<h2>Date of Birth</h2>
		<select name="birthMonth">
			<?php 
			for($month=0; $month <= 12; $month++)
			{
				$dropDown = "<option value ='". $month . "'>". $allMonths[$month]."</option>";
				echo $dropDown;
			}
			?>
		</select>
		
		<!--Get birth day-->
		<select name="birthDay">
			<?php 
			for($day=0; $day <= 31; $day++)
			{
				if ($day == 0)
				{
					echo "<option value = '$day'>--Day--</option>";
				}
				else
				{
					echo "<option value = '$day'>$day</option>";
				}
			}
			?>
		</select>
		<!--Get birth Year-->
		<select name="birthYear">
			<?php 
			for($year=2020; $year >= 1900; $year--)
			{
				if ($year == 2020)
				{
					echo "<option value = '$year'>--Year--</option>";
				}
				else
				{
					echo "<option value = '$year'>$year</option>";
				}
			}
			?>
		</select>
	</div>

	<!--buttons-->
	<table border="0" cellspacing="15" >

		<tr>
			<td><input type="submit" value = "Register" class="special"/></td>
			
			<td><a href="index.php"><input type="button" value = "Cancel" class="special"/></a></td>
		</tr>

	</table>

</form>


<!--end of main page content-->
<?php	
	 include "footer.php";
?>