<?php
/*
Name: Group 05
File: profile-search.php
Date: 2017-09-29
Description : This page will allow a user to search for another user's profile.
Course: Webd3201
*/
$title = "Profile Search";
$banner ="Profile Search";

$description ="This is the Profile search page.";
			
$filename = "profile-search.php";
include "header.php"; # bring in the header file containing a nav bar, description, heading
$conn = db_connect();
?>
<section id="banner"><h1><?php echo $banner;?></h1></section>

<?php
if($_SERVER["REQUEST_METHOD"] == "GET"){
	
	if(isset($_COOKIE['city']))
	{
		if(isset($_COOKIE['searchResults']))
		{
			$resultsList = $_COOKIE['search_results'];
			$genderSought = $resultsList['search_gender_sought'];
			$height = $resultsList['search_height'];
			$bodyType = $resultsList['search_body_type'];
			$religion = $resultsList['search_religion'];
			$hasVehicle = $resultsList['search_has_vehicle'];
			$smokes = $resultsList['search_smokes']; 
			$drinks = $resultsList['search_drinks'];
			$pets = $resultsList['search_pets'];
			$haveKids = $resultsList['search_have_kids'];
			$wantKids = $resultsList['search_want_kids'];

		}
	}
	
}else if($_SERVER["REQUEST_METHOD"] == "POST"){

	if((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn'] == true))
	{
		if(isset($_SESSION['city']))
		{
			$genderSought = $_POST['gender_sought'];
			$height = $_POST['height'];
			if($height==1)
			{
				$result = pg_query($conn, "SELECT * FROM height");
				$list = pg_fetch_all_columns($result, 0);
				$height = createSqlUsableArray($list);
			}
			else
			{
				$height="{". $_POST['height']."}";
			}
			$bodyType = $_POST['body_type'];
			if($bodyType==1)
			{
				$result = pg_query($conn, "SELECT * FROM body_type");
				$list = pg_fetch_all_columns($result, 0);
				$bodyType = createSqlUsableArray($list);
			}
			else
			{
				$bodyType="{". $_POST['body_type']."}";
			}
			$religion = $_POST['religion'];
			$hasVehicle = $_POST['has_vehicle'];
			if($hasVehicle==1)
			{
				$result = pg_query($conn, "SELECT * FROM has_vehicle");
				$list = pg_fetch_all_columns($result, 0);
				$hasVehicle = createSqlUsableArray($list);
			}
			else
			{
				$hasVehicle="{". $_POST['has_vehicle']."}";
			}
			$smokes = $_POST['smokes']; 
			if($smokes==1)
			{
				$result = pg_query($conn, "SELECT * FROM smokes");
				$list = pg_fetch_all_columns($result, 0);
				$smokes = createSqlUsableArray($list);
			}
			else
			{
				$smokes="{". $_POST['smokes']."}";
			}
			$drinks = $_POST['drinks'];
			if($drinks==1)
			{
				$result = pg_query($conn, "SELECT * FROM drinks");
				$list = pg_fetch_all_columns($result, 0);
				$drinks = createSqlUsableArray($list);
			}
			else
			{
				$drinks="{". $_POST['drinks']."}";
			}
			$pets = $_POST['pets'];
			if($pets==1)
			{
				$result = pg_query($conn, "SELECT * FROM pets");
				$list = pg_fetch_all_columns($result, 0);
				$pets = createSqlUsableArray($list);
			}
			else
			{
				$pets="{". $_POST['pets']."}";
			}
			$haveKids = $_POST['have_kids'];
			if($haveKids==1)
			{
				$result = pg_query($conn, "SELECT * FROM have_kids");
				$list = pg_fetch_all_columns($result, 0);
				$haveKids = createSqlUsableArray($list);
			}
			else
			{
				$haveKids="{". $_POST['have_kids']."}";
			}
			$wantKids = $_POST['want_kids'];
			if($wantKids==1)
			{
				$result = pg_query($conn, "SELECT * FROM want_kids");
				$list = pg_fetch_all_columns($result, 0);
				$wantKids = createSqlUsableArray($list);
			}
			else
			{
				$wantKids="{". $_POST['want_kids']."}";
			}
			$list = getCities($_COOKIE['city']);
			$city = createSqlUsableArray($list);
			$result = pg_execute($conn, "query_find_users", array($genderSought,$height,$bodyType,$city,$religion,$hasVehicle,$smokes,$drinks,$pets,$haveKids,$wantKids,MAX_RECORDS_RETRIEVED));
			$matchUsers = (pg_fetch_all($result));
			if(pg_num_rows($result) > 0)
			{
				$_SESSION['matchedUsers'] = $matchUsers;			
			}
			header('Location:profile-search-results.php');
		}
		else
		{
			header('Location:profile-city-select.php');
		}
	}
	else
	{
		header('Location:user-login.php');
	}
}

?>

<!-- the form used for input -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<?php
	$cityList = getCities($_COOKIE['city']);
	if(isset($_COOKIE['city']))
	{
		$output= "";
		if($_COOKIE['city'] == 127)
		{
			$output = "Durham Region";
		}
		else
		{
			foreach($cityList as $city)
			{
				$output .= "| " . getProperty("city",$city) . " |";
			}
		}
		$output .= " - <a href='profile-city-select.php'>Change Cities</a>";
		echo $output;
	?>
		<!-- text boxes -->
		<!-- 
		<div>
		<h2>Age</h2>
		<label for="ageMin">Min:</label>

		<select name="minAge" id="ageMin">
			<?php 
			#for($age=18; $age <= 100; $age++)
			#{
			#	echo "<option value = $age>$age</option>";
			#}
			?>
		</select>
		
		<label for="ageMax">Max:</label>		

		<select name="maxAge" id="ageMax">
			<?php 
			#for($age=19; $age <= 100; $age++)
			#{
			#	echo "<option value = $age>$age</option>";
			#}
			?>
		</select>
		</div>
		-->
		
		<div class="4u 12u$(small)">
		
			<h2>Looking For</h2>
		
			<?php buildRadio('gender_sought', 2); ?> 
		
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
			
			<h2>Religion</h2>
			
			<?php buildDropDown('religion', 64); ?>

		</div>
		
		
		<div class="4u 12u$(small)">
			
			<h2>Should they have a vehicle?</h2>
			
			<?php buildDropDown('has_vehicle', 4); ?>

		</div>

		<div class="4u 12u$(small)">
			
			<h2>Can they smoke?</h2>
			
			<?php buildDropDown('smokes', 4); ?>

		</div>
		
		<div class="4u 12u$(small)">	
			
			<h2>Can they drink?</h2>
			
			<?php buildDropDown('drinks', 4); ?>

		</div>
		
		<div class="4u 12u$(small)">	
			
			<h2>Can they have pets?</h2>
			
			<?php buildDropDown('pets', 4); ?>

		</div>
		
		<div class="4u 12u$(small)">
			
			<h2>Can they have children?</h2>
			
			<?php buildDropDown('have_kids', 4); ?>

		</div>
		
		<div class="4u 12u$(small)">
			
			<h2>Should they want more children?</h2>
			
			<?php buildDropDown('want_kids', 4); ?>

		</div>


		<!-- buttons -->
		<table border="0" cellspacing="15" >

			<tr>
				<td><input type="submit" value = "Search" class="special"/></td>
				
				<td><a href="user-dashboard.php"><input type="button" value = "Cancel" class="special"/></a></td>
			</tr>

		</table>
	<?php
	}
	else
	{
		header('Location:profile-city-select.php');
	}
	?>
</form>



<!-- end of main page content -->
<?php	
	include "footer.php"; # display the footer
?>