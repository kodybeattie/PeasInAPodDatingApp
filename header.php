<?php ob_start();?>

<?php
if(session_id()=="")
{
	session_start();
}

/*
Filename: header.php
Date Modified: 2017-11-02
Group: Group 05
Description: This is the header for every page on the site.
<meta charset="utf-8"/>
*/				
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
	
	<head>
	
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1" />
	
		<link rel="stylesheet" type="text/css" href="assets/css/webd3201.css" /> <!-- My style sheet -->

		<title><?php echo $title;?></title><!-- THE <title> WILL COME FROM A PHP VARIABLE TOO -->
	
	</head>
	<?php 
		require_once('includes/constants.php');
		require_once('includes/db.php');
		require_once('includes/functions.php');
	?>
	<body class="subpage">
		<header id="header">
			
			<div class="logo">
				<img src="images/logo.png" alt="Peas in A Pod" class="logo"/> 
			</div>
			
			<div class="inner">
			
				<a href="index.php" class="logo">PIP</a>
				
				<nav id="nav">
					
					<a href="index.php">Home</a>
					<a href="profile-search.php">Profile Search</a>

					
					<?php 
					# load links depending on the status of the user. I.E logged in or out
					if(isset($_SESSION['loggedIn']))
					{
						# if user is logged in and incomplete
						if (($_SESSION['loggedIn'] == true) && (trim($_SESSION['user_type']) == INCOMPLETE))
						{
							# load incomplete user links
							loadLoggedInIncompleteUserLinks();
						}
						elseif (($_SESSION['loggedIn'] == true) && (trim($_SESSION['user_type']) == ADMIN))
						{
							# load incomplete user links
							loadLoggedInAdminLinks();
						}
						elseif(($_SESSION['loggedIn'] == true) && (trim($_SESSION['user_type']) == CLIENT))
						{
							# if client user load standard links
							loadLoggedInUserLinks();
						}
						elseif(($_SESSION['loggedIn'] == true) && (trim($_SESSION['user_type']) == ADMIN))
						{
						?>	
							<a href="user-logout.php">Logout</a>
						<?php
						}
					}
					else
					{
						# if user not logged in load logged out links
						loadLoggedOutUserLinks();
					}
					?>
					
				</nav>
				<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
			</div>
		</header>