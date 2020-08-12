<?php
/*
Name: Group 05
File: user-logout.php
Date: 2017-09-29
Description : A user will use this page to log out
Course: Webd3201
*/
$title = "Logout";
$banner ="Farewell!";
$description ="This is where the user can log out";	
$filename = "user-logout.php";
include("header.php")
?>
<!-- Banner -->
<section id="banner">
	<h1>Logout</h1>
</section>
<!-- One -->
<section id="one" class="wrapper">
	<div class="inner">
		<div class="flex flex-3">
			<article>
				<?php
					session_unset();
					session_destroy();
					session_start();
					$_SESSION['message'] = "You have successfully logged out.";
					header('Location:user-login.php');
					echo $_SESSION['message'];
					?>

			</article>
		</div>
	</div>
</section>

<!-- Footer -->
<?php include("footer.php") ?>