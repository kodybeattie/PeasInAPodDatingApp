<?php
/*
Name: Group 05
File:  profile-display.php
Date: 2017-09-29
Description : This is where the profile would be displayed.
Course: Webd3201
*/
$title ="Profile Display";
$banner ="Your Profile";

$description ="This is where the profile would be displayed.";
			
$filename = "profile-display.php";

include "header.php"; # bring in the header file containing a nav bar, description, heading
$conn = db_connect();



if(isset($_GET['displayId']))
{
	$displayId = $_GET['displayId'];
	$message = "Here is:";
}
else
{
	$displayId = $_SESSION['user_id'];
	$message = "This is what your profile looks like to others.";
}

$result = pg_execute($conn,"query_get_profile",array($displayId));
if(pg_num_rows($result)>0)
{
	$row = pg_fetch_assoc($result);
	$result = pg_execute($conn,"query_get_user_type",array($displayId));
	$userType = trim(pg_fetch_result($result,0,0));

	if($_SESSION['loggedIn'] == true && $displayId != $_SESSION['user_id'])
	{
		$result = pg_execute($conn,"query_check_if_reporter_viewing",array($displayId,$_SESSION['user_id']));
		if((pg_num_rows($result) == 0) && (trim($_SESSION['user_type']) != ADMIN))
		{
		?>
			<section id="one" class="wrapper style1 special">
				<div>	
				<form action="" method="post">
					<input type="submit" name="btnReport" value ="Report User" class="special"/>
				</form>
				</div>
			</section>
		<?php
		}
		elseif(pg_num_rows($result) == 1)
		{
			$message="We are reviewing your report for this user. Thank you.";
		}
		
		$result = pg_execute($conn, "query_check_if_reported", array($displayId));
		if(pg_num_rows($result) > 0)
		{
			if(trim($_SESSION['user_type']) == ADMIN)
			{
				$result = pg_execute($conn,"query_update_ticket_status",array(STATUS_CLOSED,$displayId));
			}
		}
		
		$result1 = pg_execute($conn, "query_find_interest", array($_SESSION['user_id'], $displayId));

		$result2 = pg_execute($conn, "query_find_interest", array($displayId, $_SESSION['user_id']));

		if(pg_num_rows($result1) == 1 && pg_num_rows($result2) == 1)
		{
			$message= "You and ". $displayId . " liked each other!";
		}
		elseif(pg_num_rows($result1) > 0)
		{
			echo "You like " . $displayId;
		?>
		<section id="one" class="wrapper style1 special">
			<div>	
			<form action="" method="post">
				<input type="submit" name="btnDislike" value = "Unlike" class="special"/>
			</form>
			</div>
		</section>
		<?php	
		}
		else
		{
		?>
		<section id="one" class="wrapper style1 special">
			<div>	
			<form action="" method="post">
				<input type="submit" name="btnLike" value = "Like" class="special"/>
			</form>
			</div>
		</section>
		<?php
		}	
	}


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if($_SESSION['loggedIn'] == true)
		{
			if (trim($_SESSION['user_type']) == ADMIN)
			{
				if($userType == CLIENT && isset($_POST['btnDisableUser']))
				{
					$result = pg_execute($conn,"query_update_user_type",array(DISABLED,$displayId));
					$message = "User disabled, they will no longer be able to login.";
					$result = pg_execute($conn, "query_delete_disabled_interest",array($displayId));
				}
				elseif($userType == DISABLED && isset($_POST['btnEnableUser']))
				{
					$result = pg_execute($conn,"query_update_user_type",array(CLIENT,$displayId));
					$message = "User enabled, they can login now.";
				}
			}
			
			if(isset($_POST['btnDislike']))
			{
				$result = pg_execute($conn, "query_delete_interest", array($_SESSION['user_id'], $displayId));
			}
			elseif(isset($_POST['btnLike']))
			{
				$result = pg_execute($conn, "query_insert_interest", array($_SESSION['user_id'], $displayId));
			}
			
			if(isset($_POST['btnReport']))
			{
				$result = pg_execute($conn, "query_report_user",array($displayId, $_SESSION['user_id'], STATUS_OPEN));

			}
			header("Refresh:0");
		}
	}

	?>
	<section id="one" class="wrapper style1 special">

	<?php
	if (trim($_SESSION['user_type']) == ADMIN)
	{
		if($userType == CLIENT)
		{
	?>
		<div>	
		<form action="" method="post">
			<input type="submit" name="btnDisableUser" value = "Disable User" class="special"/>
		</form>
		</div>
	<?php
		}
		elseif($userType == DISABLED)
		{
	?>
		<div>	
		<form action="" method="post">
			<input type="submit" name="btnEnableUser" value = "Enable User" class="special"/>
		</form>
		</div>
	<?php
		}
	}
	?>
	</section>
	<section id="two" class="wrapper style1 special">
		<div class="inner">
			<header>
				<h2><?php echo $message; ?></h2>
				<h2><?php echo $displayId; ?></h2>
				<h2><?php echo($row['headline']); ?></h2>
				
				<div class="box person">
					<div class="image round">
						<img src="<?php echo "images/".$displayId."/".$displayId."_1.jpg";?>" alt="Image"/>
					</div>
				</div>
				
				<div class="inner">

					<?php
				
						echo "Gender: " . getProperty('gender',$row['gender']) . "</br>";
						echo "Looking For: " . getProperty('gender_sought',$row['gender_sought']) . "</br>";
						echo "Lives in: " . getProperty('city',$row['city']) . "</br>";
						echo "Religion: " . getProperty('religion',$row['religion']) . "</br>";
						echo "Body Type: " . getProperty('body_type',$row['body_type']) . "</br>";
						echo "Height: " . getProperty('height',$row['height']) . "</br>";
						echo "Drinks: " . getProperty('drinks',$row['drinks']) . "</br>";
						echo "Smokes: " . getProperty('smokes',$row['smokes']) . "</br>";
						echo "Has Pets: " . getProperty('pets',$row['pets']) . "</br>";
						echo "Has Vehicle: " . getProperty('has_vehicle',$row['has_vehicle']) . "</br>";
						echo "Has Kids: " . getProperty('have_kids',$row['have_kids']) . "</br>";
						echo "Wants more Kids: " . getProperty('want_kids',$row['want_kids']) . "</br>";
						echo "</br>";
						echo "Self Description". "</br>";
						echo  ($row['self_description']) . "</br>";
						echo "</br>";
						echo "Match Description". "</br>";
						echo  ($row['match_description']) . "</br>";
						
					?>
				</div>
				<div class="inner">
					<h2>Images</h2>
					<p>These are the images this user has uploaded</p>
				</div>
			</header>
			<!--Change images to be relative-->
			<div class="flex flex-4">
				<div class="box person">
					<div class="image round">
						<img src="images/pic04.jpg" alt="Image 2" />
					</div>
				</div>

				<div class="box person">
					<div class="image round">
						<img src="images/pic05.jpg" alt="Image 3" />
					</div>
				</div>

				<div class="box person">
					<div class="image round">
						<img src="images/pic06.jpg" alt="Image 4" />
					</div>
				</div>

				<div class="box person">
					<div class="image round">
						<img src="images/pic06.jpg" alt="Image 5" />
					</div>
				</div>

				<div class="box person">
					<div class="image round">
						<img src="images/pic06.jpg" alt="Image 6" />
					</div>
				</div>

				<div class="box person">
					<div class="image round">
						<img src="images/pic06.jpg" alt="Image 7" />
					</div>
				</div>

				<div class="box person">
					<div class="image round">
						<img src="images/pic06.jpg" alt="Image 8" />
					</div>
				</div>

				<div class="box person">
					<div class="image round">
						<img src="images/pic06.jpg" alt="Image 9" />
					</div>
				</div>

			</div>
		</div>
	</section>

<!-- end of main page content -->
<?php
}	
else
{
	echo"This is user hasn't completed their profile yet.";
}
	include "footer.php"; # display the footer
?>