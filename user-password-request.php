<?php 

# user-password-request.php
/*
Name: Group 05
File: user-password-request.php
Date: 2017-11-21
Description : This is where the user will be able to request a password change
Course: Webd3201
*/

$title ="Password Recover";
$banner ="Password Recovery";
$description ="This is where the user will be able to request a password change";			
$filename = "user-password-request.php";

include "header.php"; # bring in the header file containing a nav bar, description, heading
$conn = db_connect();
?>

<!-- Banner -->
<section id="banner">
	<h1>Password Recovery</h1>
	<p>A free responsive HTML5 website template by TEMPLATED.</p>
</section>

<?php
	$error = ""; # contains the error message string

if($_SERVER["REQUEST_METHOD"] == "GET"){

$userId= "";
$emailAddress = ""; # stores the users email


}else if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$loginId = trim($_POST["txtUserId"]);
	$emailAddress = trim($_POST["txtInputEmail"]); //the name of the email input box on the form, white-space removed
	//let's do some data validation
	
	if($userId =="")
	{
		$error.="Please enter a login Id.";
	}
	
	if($emailAddress == "")
	{
		//means the user did not enter anything
		$error .= "Please enter an email.\n";
	}
	else if (filter_var($emailAddress, filter_validate_email))
	{
		$error .= "This email is invalid.\n";
	}
	else
	{
		$result = pg_execute($conn,"query_check_if_exist_userid", array($loginId));
		if(pg_num_rows($result)>0)
		{
			$result = pg_execute($conn,"query_get_email",array($loginId));
			if(pg_num_rows($result)>0)
			{
				$dbEmail = pg_fetch_result($result,0,'email_address');
				if($email_address != $dbEmail)
				{
					$error.="Email does not match our records.";
				}	
			}
		}
		else
		{
			$error.= "Login Id not found in database.";
		}
	}
	
	if ($error == "")
	{	
		$conn = db_connect(); # connect to the database
		
		if ($conn === false) # connection failed
		{
			$error .= "Could not connect to database.\n";
		}
		else # connection successful*/
		{
			$newUserPassword = (getRandomString(8,8));
			$today = date(DATE_RFC2822);
			$to = $email_address;
			$subject ="Peas in A Pod Password Request";
			$message ='
			<html>
				<head>
					<img src="images/logo.png" alt"PIPLOGO" height="42" width="42">
					<title>
						Password Request
					</title>
				</head>
				
				<body>
					<p>
						Here is your new password. Please
						use it to login from this time until
						you change it.
						</br>
						</br>
						<a href="user-login.php">Login Here</a>
						</br>
						</br>
			';			
			$message.= ' <b>Password = '.$newUserPassword.'</b>';
			$message.='	
						Thank you for being a valued customer,
								The PIP team.
			';					
								
			$message.=' Sent - '. $today;
			$message.='
					</p>
				</body>
			</html>
			';
			$headers[]= 'MIME-Version: 1.0';
			$headers[]= 'Content-type: text/html; charset=iso-8859-1'; 
			
			#mail($to,$subject,$message,$headers);
			
			$result = pg_execute($conn,"query_change_user_password",array(md5($newUserPassword),$loginId));
		}
	}
}

?>

<!-- Email Recovery section -->
			<section id="one" class="wrapper">
			
				<div class="inner">
					<div class="flex flex-3">
						<article>
							<h3> Password Recovery</h3>
								<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<div class="row uniform">
										<div class="6u$ 12u$(xsmall)">
											<?php echo $error; ?>
										</div>
										<div class="6u$ 12u$(xsmall)">
											<input type="text" name="txtUserId" placeholder="User Id" value="<?php echo $userId;?>" size="20" />
										</div>
										<div class="6u$ 12u$(xsmall)">
											<input type="email" name="txtInputEmail" placeholder="Email" value="<?php echo $emailAddress;?>" size="20" />
										</div>			
							<footer>
							<a type="submit" class="button special">Recover Password</a>
								
							</footer>
						</article>
					</div>
				</div>
			</section>


<!-- end of main page content -->
<?php	
	 include "footer.php";
?>
