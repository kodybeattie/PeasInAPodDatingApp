<?php #user-update.php

/*
Name: Group 05
File:  user-update.php
Date: 2017-11-21
Description : This is where the user will be able to update user statistics
Course: Webd3201
*/

$title ="Update your user info";
$banner ="User Update";
$description ="This is where you can update your user info";			
$filename = "profile-images.php";
include "header.php"; # bring in the header file containing a nav bar, description, heading
$error = "";

# Get user id
if(isset($_GET['displayId']))
{
	$displayId = $_GET['displayId'];	
}
else
{
	$displayId = $_SESSION['user_id'];
}

$conn = db_connect(); # connect to database
	
# if connection fails
if ($conn == false)
{
	$error .= "Could not connect to database.";
}
else
{

$result = pg_execute($conn,"query_get_user",array($displayId));
$row = pg_fetch_row($result);	

if($_SERVER["REQUEST_METHOD"] == "GET"){
	$emailAddress = $row[3]; # users email address
	$isValidEmail = true; # used to confirm if user email is valid address
	$firstName = $row[4]; # users first name
	$lastName = $row[5]; # users last name
	$birthDate = $row[6]; # users birth date
	
	$orderdate = explode('-', $birthDate);
	$birthYear  = (int) $orderdate[0];
	$birthMonth = (int) $orderdate[1];
	$birthDay   = (int) $orderdate[2];
	
}else if($_SERVER["REQUEST_METHOD"] == "POST"){
	# pull info from the post array
	$emailAddress = trim($_POST["txtInputEmail"]);
	$firstName = trim($_POST["txtInputFirstName"]);
	$lastName = trim($_POST["txtInputLastName"]);
	$birthDay = ($_POST["birthDay"]);
	$birthMonth = ($_POST["birthMonth"]);
	$birthYear = ($_POST["birthYear"]);
	
	#create bithdate string
	$birthDate= $birthYear . "," . $birthMonth . "," . $birthDay;
	
	# confirm email is a valid address
	$isValidEmail = FILTER_VAR($emailAddress, FILTER_VALIDATE_EMAIL);
	if ($isValidEmail == false)
	{
		$error .= "Email address is invalid. Please enter a valid email address.";
	}
	
	# ensure first name isn't blank
	if ($firstName == "")
	{
		$error .= "You still need a first name.";
		$firstName = $row[4];
	}
	
	#ensure last name isn't blank
	if ($lastName == "")
	{
		$error .= "You still need a last name.";
		$lastName = $row[5];
	}
	
	# calculate the users age ensure they are over 18
	if ((calculateAge($birthDate)) < MIN_REGISTER_AGE)
	{
		$error .= "You must still be at least 18.";
		$birthDate = $row[6];
		
		$orderdate = explode('-', $birthDate);
		$birthyear  = $orderdate[0];
		$birthMonth = $orderdate[1];
		$birthDay   = $orderdate[2];
	}
	
	#update the info. There can be errors, because we reset the problematic entries.
	$result = pg_execute($conn, "query_update_user", array($loginId, $emailAddress, $firstName, $lastName, $birthDate));
		
	}
}

?>


<section id="banner">
<h1>Update User Info</h1>
<h3><?php echo $error; ?></h3>
</section>
<!-- The form used for input -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >

	<!--text boxes-->
	<table>		
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
		<select selected=$birthMonth name="birthMonth">
			<?php 
			for($month=0; $month <= 12; $month++)
			{	
				$isselect="";
				if ($month == $birthMonth)
				{
				$isselect='selected="selected"';
				}
				
				$dropDown = "<option value ='$month' $isselect>$allMonths[$month]</option>";
				echo $dropDown;
			}
			?>
		</select>
		
		<!--Get birth day-->
		<select selected=$birthDay name="birthDay">
			<?php 
			for($day=0; $day <= 31; $day++)
			{
				$isselect="";
				if ($day == $birthDay)
				{
				$isselect='selected="selected"';
				}
				if ($day == 0)
				{
					echo "<option value = '$day'>--Day--</option>";
				}
				else
				{
					echo "<option value = '$day' $isselect>$day</option>";
				}
			}
			?>
		</select>
		<!--Get birth Year-->
		<select name="birthYear">
			<?php 
			for($year=2020; $year >= 1900; $year--)
			{
				$isselect="";
				if ($year == $birthYear)
				{
				$isselect='selected="selected"';
				}
				
				if ($year == 2020)
				{
					echo "<option value = '$year'>--Year--</option>";
				}
				else
				{
					echo "<option value = '$year' $isselect>$year</option>";
				}
			}
			?>
		</select>
	</div>

	<!--buttons-->
	<table border="0" cellspacing="15" >

		<tr>
			<td><input type="submit" value = "Update" class="special"/></td>
			
			<td><a href="index.php"><input type="button" value = "Cancel" class="special"/></a></td>
		</tr>

	</table>

</form>


<!--end of main page content-->
<?php	
	 include "footer.php";
?>