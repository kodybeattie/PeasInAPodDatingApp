<?php
/*
Name: Group 05
File:  profile-update.php
Date: 2017-09-29
Description : This is where the user can update their profile settings
Course: Webd3201
*/


$title ="Update your profile";
$banner ="Update a Profile";
			
$filename = "profile-update.php";
include "header.php"; # bring in the header file containing a nav bar, description, heading

$error = "";

if($_SERVER["REQUEST_METHOD"] == "GET"){

	if ($_SESSION['user_type'] == INCOMPLETE)
	{
		$headline=""; # the users profile headline - a short message
		$gender=1; # users gender
		$genderSought=1; # the gender user is looking for
		$city=1; # city the user lives in
		$selfDescription=1; # how user describes themselves
		$matchDescription=1; # how user describes perfect match
		$height=1; # users height
		$bodyType=1; # users body type
		$haveKids=1; # does the the user have kids
		$smokes=1; # does the user smoke
		$drinks=1; # does the user drink
		$pets=1; # does the user have pets
		$hasVehicle=1; # does the user have a vehicle
		$wantsKids=1; # does the user want more kids
		$religion=1; # what religion does user follow
	}
	else if(isset($_SESSION['loggedIn'])) #Check if the user is logged in
	{
		#If logged in. Check if the user is complete 
		if ($_SESSION['user_type'] == CLIENT)
		{
			echo "User is complete";
		}
	}
	else
	{
		# grab and trim all fields involving text input
		$userId = trim($_SESSION['user_id']);
		$headline = trim($_SESSION['headline']);
		$selfDescription = trim($_SESSION['self_description']);
		$matchDescription = trim($_SESSION['match_description']);
		
		# grab all properties from POST array
		$gender = $_SESSION['gender'];
		$genderSought = $_SESSION['gender_sought'];
		$city = $_SESSION['city'];
		$height = $_SESSION['height'];
		$bodyType = $_SESSION['body_type'];
		$haveKids = $_SESSION['have_kids'];
		$smokes = $_SESSION['smokes'];
		$drinks = $_SESSION['drinks'];
		$pets = $_SESSION['pets'];
		$hasVehicle = $_SESSION['has_vehicle'];
		$wantKids = $_SESSION['want_kids'];
		$religion = $_SESSION['religion'];
	}

}else if($_SERVER["REQUEST_METHOD"] == "POST"){
	

	# grab and trim all fields involving text input
	$userId = trim($_SESSION['user_id']);
	$headline = trim($_POST['headline']);
	$selfDescription = trim($_POST['selfDescription']);
	$matchDescription = trim($_POST['matchDescription']);
	
	# grab all properties from POST array
	$gender = $_POST['gender'];
	$genderSought = $_POST['gender_sought'];
	$city = $_POST['city'];
	$height = $_POST['height'];
	$bodyType = $_POST['body_type'];
	$haveKids = $_POST['have_kids'];
	$smokes = $_POST['smokes'];
	$drinks = $_POST['drinks'];
	$pets = $_POST['pets'];
	$hasVehicle = $_POST['has_vehicle'];
	$wantKids = $_POST['want_kids'];
	$religion = $_POST['religion'];

	# if no errors attempt to connect to database
	if ($error == "")
	{	
		$conn = db_connect(); # connect to the database
		
		if ($conn === false) # connection failed
		{
			$error .= "Could not connect to database.\n";
		}
		else # connection successful
		{
			# data validate all fields involving text input
			if ($headline == "")
			{
				$error .= "Please enter a headline.<br/>";
			}
			
			if ($selfDescription == "")
			{
				$error .= "Please enter a self description.<br/>";
			}
			
			if ($matchDescription == "")
			{
				$error .= "Please describe your perfect match.<br/>";
			}
			
			# if data all good
			if ($error == "")
			{	
				# if the user's type is incomplete
				if (trim($_SESSION['user_type']) == INCOMPLETE)
				{
					# input data into profiles table
					$result = pg_execute($conn, "query_complete_profile", array($userId, $gender, $genderSought, $city, $headline, $selfDescription, $matchDescription, $height, $bodyType, $haveKids, $smokes, $drinks, $pets, $hasVehicle, $wantKids, $religion));
					# update the user to a client user
					$result = pg_execute($conn, "query_update_user_type", array(CLIENT, $userId));
					# let them know their profile was made
					$_SESSION['message'] = "Profile created successfully.";
				}
				else
				{
					# if user is not incomplete - update their profile with the new values
					$result = pg_execute($conn, "query_update_profile", array($gender, $genderSought, $city, $headline, $selfDescription, $matchDescription, $height, $bodyType, $haveKids, $smokes, $drinks, $pets, $hasVehicle, $wantKids, $religion, $userId));
					$_SESSION['message'] = "Profile updated successfully.";

				}
				$_SESSION['loggedIn'] = false;
				# get the users profile
				$result = pg_execute($conn, "query_get_profile", array($userId));
				$row = pg_fetch_assoc($result);
				# add the users profile to the session
				foreach ($row as $key =>$value)
				{
					$_SESSION[$key] = $value; 
				}
				header('Refresh:2; url=user-dashboard.php');
				echo $_SESSION['message'];
			}
		}
	}
}

?>

<section id="banner">
<h1><?php echo $banner;?></h1>
<h3><?php echo $error; ?></h1>
</section>
<!-- the form used for input -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  >


	<div>
	
		<h2>Headline</h2>

		<input name="headline" type="text" value="<?php echo $headline; ?>">
		
	</div>

 	<div class="4u 12u$(small)">

		<h2>Gender</h2>

		<?php buildRadio('gender', 4); ?>
		
	</div>
	

	<div class="4u 12u$(small)">
	
	
	<h2>Looking For</h2>
	
		<?php buildRadio('gender_sought', 2); ?> 
	
	</div>

 	<div>
	
		<h2>My perfect match is...</h2>

		<textarea name="matchDescription" rows="10" cols="35" value="">
		<?php
			echo ($matchDescription);
		?>
		</textarea>
		
	</div>
	
	<div class="4u 12u$(small)">
		
		<h2>Height</h2>
		
		<?php buildDropDown('height', 16384); ?>

	</div>
	
		<div class="4u 12u$(small)">
		
		<h2>Body Type</h2>
		
		<?php buildDropDown('body_type', 8); ?>

	</div>
	
	<div class="6u 12u$(small)">
		
		<h2>City</h2>
		
		<?php buildDropDown('city', 64); ?>

	</div>

	<div class="6u 12u$(small)">
		
		<h2>Religion</h2>
		
		<?php buildDropDown('religion', 64); ?>

	</div>
	
	
	<div class="4u 12u$(small)">
		
		<h2>Do you have a car?</h2>
		
		<?php buildDropDown('has_vehicle', 4); ?>

	</div>

	<div class="4u 12u$(small)">
		
		<h2>Do you smoke?</h2>
		
		<?php buildDropDown('smokes', 4); ?>

	</div>
	
	<div class="4u 12u$(small)">	
		
		<h2>Do you drink?</h2>
		
		<?php buildDropDown('drinks', 4); ?>

	</div>
	
	<div class="4u 12u$(small)">	
		
		<h2>Do you have pets?</h2>
		
		<?php buildDropDown('pets', 4); ?>

	</div>
	
	<div class="4u 12u$(small)">
		
		<h2>Do you have children?</h2>
		
		<?php buildDropDown('have_kids', 4); ?>

	</div>
	
	<div class="4u 12u$(small)">
		
		<h2>Do you want more children?</h2>
		
		<?php buildDropDown('want_kids', 4); ?>

	</div>
	
	<div>
		
		<h2>Tell us about yourself</h2>

		<textarea name="selfDescription" rows="1" cols="1">
		<?php
				echo ($selfDescription);
		?>
		</textarea>
		
	</div>
	
	<div>
		
		<h3>Upload Profile Picture</h3>
		
		<input type="file" name="pic" accept="image/*">
	
	</div>
	
	<!-- buttons -->
	<table border="0" cellspacing="15" >

		<tr>
			<?php
			if ($_SESSION['user_type'] == INCOMPLETE)
			{
				echo "<td><input type='submit' value = 'Create Profile' class='special'/></td>";
			}
			else
			{
				echo "<td><input type='submit' value = 'Update Profile' class='special'/></td>";
			}
			?>
			<td><a href="index.php"><input type="button" value = "Cancel" class="special"/></a></td>
		</tr>

	</table>

</form>



<!-- end of main page content -->
<?php	
	 include "footer.php";
?>