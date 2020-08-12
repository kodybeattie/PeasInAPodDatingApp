<?php
/*
Name: Group 05
File: user-login.php
Date: 2017-09-29
Description : The login page.
Course: Webd3201
*/
$title = "Login";
$banner ="Returning member?";
$description ="This is where the user can log in";
$filename = "user-login.php";
$test = "Login";
include("header.php");

$error = ""; # contains the error message string
if (!isset($_SESSION['message']))
{
	$_SESSION['message'] = "Please login.";
}

if($_SERVER["REQUEST_METHOD"] == "GET"){

if (isset($_COOKIE['cookie_user_id']))
{
	$login = ($_COOKIE['cookie_user_id']);
}
else
{
	$login = ""; # stores the users login ID
}

$pass = ""; # stores the users password



}else if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$login = trim($_POST["txtUserID"]); //the name of the input box on the form, white-space removed
	$pass = trim($_POST["txtPassword"]); //the name of the input box on the form, white-space removed
	//let's do some data validation
	
	if($login == "")
	{
		//means the user did not enter anything
		$error .= "Please enter a user id.\n";
	}
	
	
	if($pass == "")
	{
		//means the user did not enter anything
		$error .= "Please enter a password.\n";
	}
	
	# DATA is good begin database work
	
	if ($error == "")
	{	
		$conn = db_connect(); # connect to the database
		
		if ($conn === false) # connection failed
		{
			$error .= "Could not connect to database.\n";
		}
		else # connection successful*/
		{
			
			# look for user's login credentials

			$pass = md5($pass);
			# run query in database
			
			$result = pg_execute($conn, "query_get_login", array($login,$pass));
			# if query fail
			if ($result === false)
			{
				$error .= "Cannot query database.\n";
			}
			# if something found in database
			else if (pg_num_rows($result) > 0)
			{
				$row = pg_fetch_assoc($result);
				$user_type = $row['user_type'];
				setcookie("cookie_user_id", $row['user_id'], (time()+ (86400 * 30)));


				# update the user's last login date
				# run the query in the database
				$result = pg_execute($conn, "query_update_last_access", array(date("Y-m-d",time()), $login));
			
				$result = pg_execute($conn, "query_get_login", array($login,$pass));
				
				# add all user info to the session
				$row = pg_fetch_assoc($result);
				$_SESSION['loggedIn'] = true;
				foreach ($row as $key =>$value)
				{
					$_SESSION[$key] = $value; 
				}
				
				#if user is incomplete 
				if (trim($user_type) == INCOMPLETE)
				{
					# head to profile create page
					header('Location:profile-create.php');
				}
				# if user is client or 
				else if(trim($user_type) == CLIENT || trim($user_type) == ADMIN)
				{
					# get the users profile
					$result = pg_execute($conn, "query_get_profile", array($login));
					$row = pg_fetch_assoc($result);
					# add the users profile to the session
					foreach ($row as $key =>$value)
					{
						$_SESSION[$key] = $value; 
					}
					if (trim($user_type) == ADMIN)
					{
						header('Location:admin.php');
					}
					elseif(trim($user_type)==CLIENT)
					{
						header('Location:user-dashboard.php');
					}
					elseif(trim($user_type)==DISABLED)
					{
						header("Refresh:7; url=aup.php");
						echo "Your account has been disabled for misuse. Please review our Acceptable use Policy in the meantime.";
					}
				}
			}
			else
			{
				$error .= "Username not found. Please register for our site.";
			}
		}
	}
}

?>

<!-- Banner -->
<section id="banner">
	<h1>Login</h1>
</section>


<!-- One -->
<section id="one" class="wrapper">
	<div class="inner">
		<div class="flex flex-3">
			<article>
				<h3>Login</h3>
					<h3><?php echo $_SESSION['message'];?></h3>
					<h3><?php echo $error; ?></h3>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="row uniform">
							<div class="6u$ 12u$(xsmall)">
								<input type="text" name="txtUserID" value="<?php echo trim($login); ?>" placeholder="Username" size="50"/>
							</div>
							<div class="6u 12u$(xsmall)">
								<input type="password" name="txtPassword" value="" placeholder="Password" />
							</div>
					
						</div>
						</br>
						<div>
							<input type="submit" value = "Login" class="special"/>
						</div>
					</form>
			</article>
		</div>
	</div>
</section>

<!-- Footer -->
<?php include("footer.php") ?>