<?php 

# user-password-change.php
/*
Name: Group 05
File: user-password-change.php
Date: 2017-11-21
Description : This is where the user will be able to change their password
Course: Webd3201
*/

$title ="Change Password";
$banner ="Change Password";
$description ="This is where the user will be able to change their password";			
$filename = "user-password-change.php";

include "header.php"; # bring in the header file containing a nav bar, description, heading

$conn = db_connect();
?>

<!-- Banner -->
<section id="banner">
	<h1>Change Passowrd</h1>
</section>

<?php
	$error = ""; # contains the error message string

if($_SERVER["REQUEST_METHOD"] == "GET"){

$oldPassword = "";
$confirmOldPassword = "";
$newPassword = "";
$confirmNewPassword = "";

}else if($_SERVER["REQUEST_METHOD"] == "POST"){
	if($_SESSION['loggedIn'] == true)
	{
		$oldPassword = trim($_POST["txtOldPassword"]);
		$newPassword = trim($_POST["txtNewPassword"]);
		$confirmNewPassword = trim($_POST["txtConfirmNewPassword"]);
		
		$result = pg_execute($conn, "query_get_user_password", array($_SESSION['user_id']));
		
		if($oldPassword = "")
		{
			$error .= "Please enter your old password.";
		}
		
		if($newPassword = "")
		{
			$error .= "Please enter a new password.";
		}
		
		if($confirmNewPassword = "")
		{
			$error .= "Please confirm your new password";
		}
		
		if(pg_num_rows($result) > 0)
		{
			$confirmOldPassword = pg_fetch_result($result,0,0);
		}
		else
		{
			$error .= "You old password was not found in our database. Please enter your old password";
		}
		
		if(!(md5($oldPassowrd) == $confirmOldPassword))
		{
			$error .= "Your old pssword is incorrect, please enter the oorrect password.";
		}
		
		if((strlen($newPassword) < PASSWORD_LENGTH_MIN) || (strlen($newPassword) > PASSWORD_LENGTH_MAX))
		{
			$error .= "Please enter a new password between " . PASSWORD_LENGTH_MIN . " and " . PASSWORD_LENGTH_MAX . ".";
		}
		
		if(!($newPassoword == confirmNewPassword))
		{
			$error .= "Your passwords do not match please re-enter your new password.";
		}
		
		if($error = "")
		{
			$newPassword = md5($newPassword);
			$result = pg_execute($conn, "query_change_user_password", array($newPassword, $_SESSION['user_id']));
			if($result == false)
			{
				$error .= "Password failed to update.";
			}
			else
			{
				$_SESSION['message'] = "Password updated succesfully.";
				header('Location:user-dashboard.php');

			}
		}
	}
	else
	{
		#error .= "Please login to change your password.";
		header('Location:user-login.php');

	}
}

?>

<!-- Email Recovery section -->
<section id="one" class="wrapper">
	<div class="inner">
		<div class="flex flex-3">
			<article>
			<h2>Username: <?php echo $_COOKIE['cookie_user_id'];?></h2>
				<h3>Fill out the fields to change your password</h3>
				
					<form method="post" action="#">
						<div class="row uniform">
							
							<div class="6u$ 12u$(xsmall)">
								<input type="password" name="txtOldPassword" value="" placeholder="Old Password" size="20" />
							</div>
							<div class="6u$ 12u$(xsmall)">
								<input type="password" name="txtNewPassword" placeholder="New Password" value="" size="20" />
							</div>	
							<div class="6u$ 12u$(xsmall)">
								<input type="password" name="txtConfirmNewPassword" placeholder="Conirm New Password" value="" size="20" />
							</div>	
				<footer>
				<a href="#" class="button special">Change Password</a>
					
				</footer>
			</article>
		</div>
	</div>
</section>


<!-- end of main page content -->
<?php	
	 include "footer.php";
?>
