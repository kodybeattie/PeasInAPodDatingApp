<?php

/*
Name: Group 05
File: interests.php
Date: 2017-12-30
Description :Display users interests.
Course: Webd3201
*/

$title = "Interests";
$banner ="Interests";

$description ="Users can search for other users by filtering profiles. This page will display the results.";
			
$filename = "interests.php";

include("header.php");

$conn = db_connect();
?>
<section id="two" class="wrapper style1 special">
	<div class="inner">
		<header>
			<h2>Interests</h2>
		</header>
	</div>
</section>
<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST['unlikes']))
	{
		foreach($POST['unlikes'] as $unlike)
		{
			pg_execute($conn, "query_delete_interest", array($_SESSION['user_id'], $unlike));
		}
	}
	if(isset($_POST['removeInterests']))
	{
		foreach($_POST['removeInterests'] as $removeInterest)
		{
			pg_execute($conn, "query_delete_interest", array($removeInterest, $_SESSION['user_id']));		
		}
	}
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
if($_SESSION['loggedIn']==true)
{
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	echo"You Like";
	echo "</td>";
	echo "<td>";
	echo "Likes You";
	echo "</td>";
	echo"</tr>";
	echo"<tr>";
		$likesResults = pg_execute($conn, "query_find_user_interests", array($_SESSION['user_id']));
		$otherResults = pg_execute($conn, "query_find_other_interests", array($_SESSION['user_id']));
		if(pg_num_rows($likesResults)>0)
		{
			$userLikes=pg_fetch_assoc($likesResults);
		}
		if(pg_num_rows($otherResults)>0)
		{
			$otherLikes=pg_fetch_assoc($otherResults);
		}
		echo"<td>";
			if(isset($userLikes))
			{
				foreach($userLikes as $like)
				{
					createProfilePreview($like);
					?>
					<input id="<?php echo $like ?>" type="checkbox" name="unlikes[]" value = "<?php echo $like?>"/><label for="<?php echo $like ?>">Unlike</label>

					<?php
					if(isset($otherLikes))
					{
						if(in_array($like,$otherLikes))
						{
							echo "You and ". $like ." are a match!";
						}
					}
				}
			}
		echo"</td>";
		echo"<td>";
			if(isset($otherLikes))
			{
				foreach($otherLikes as $like)
				{
					createProfilePreview($like)
					?>
					<input id="<?php echo $like ?>" type="checkbox" name="removeInterests[]" value = "<?php echo $like?>"/><label for="<?php echo $like ?>">Remove Like</label>
					<?php
				}
			}
		echo"</td>";
		echo"</tr>";
	echo"</table>";
}
	?>	
		<input type="submit" name="btnSubmit" value ="Submit" class="special"/>
	</form>
<?php
include("footer.php");
?>