<!--
	Theory by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->

<?php
/*
Name: Group 05
File: user-dashboard.php
Date: 2017-09-29
Description : This is the Dashboard.
Course: Webd3201
*/

$title = "Dashboard";
?>

<?php 
	include 'header.php';
	$conn = db_connect();
	#Output personalized message
	if(trim($_SESSION['user_type']) == ADMIN)
	{
		$welcome_message = "Welcome ADMINISTRATOR " . $_SESSION['first_name'] . " " . $_SESSION["last_name"] . "!";
		$last_accessed_message = "Last Access: " . $_SESSION['last_accessed'];
	?>

			<!-- Banner -->
				<section id="banner">
					<h1><?php echo $welcome_message; ?></h1>
					<h4><?php echo $last_accessed_message; ?></h4>
				</section>

			<!-- Scrolling Pre heading -->
				<section id="one" class="wrapper style1 special">
					<div class="inner">
						<header>
							<h2>Dashboard Control</h2>
							
						</header>
						<!-- Vertical images that have text under each -->
						<div class="flex flex-4">
							<div class="box person">
								<div class="image round">
									<img src="images/pic03.jpg" alt="Person 1" />
								</div>
								<h3>Search</h3>
								<p>Find someonw with your preference</p>
							</div>
							<div class="box person">
								<div class="image round">
									<img src="images/pic04.jpg" alt="Person 2" />
								</div>
								<h3>Profile</h3>
								<p>View your stats and edit if need be</p>
							</div>
							<div class="box person">
								<div class="image round">
									<img src="images/pic05.jpg" alt="Person 3" />
								</div>
								<h3>Random Pod</h3>
								<p>Randomly select a group of people for you to see!</p>
							</div>
						</div>
					</div>
					<?php
					$reported = pg_query($conn, "SELECT user_id_reported, user_id_reporting, status FROM offensives WHERE NOT status='C'");
					if(pg_num_rows($reported)>0)
					{
						for($i=0; $i<pg_num_rows($reported); $i++)
						{
							$user = pg_fetch_result($reported, $i, 0);
							$reporting = pg_fetch_result($reported, $i, 1);

							echo "<table>";
							echo "<tr>";
							echo"<td>";
							createProfilePreview($user);
							echo"</td>";
							echo"<td>";
							createProfilePreview($reporting);
							echo"</td>";
						
						}
					}
		?>	
				</section>
		
<?php
	}
	else
	{
		echo"You're not an admin, how'd you get here?";
	}
	?>
	<!-- Footer -->
<?php include('footer.php') ?>