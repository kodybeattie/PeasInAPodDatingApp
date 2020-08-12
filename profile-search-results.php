<?php

/*
Name: Group 05
File: profile-search-results.php
Date: 2017-09-29
Description : Users can search for other users by filtering profiles.
			This page will display the results.
Course: Webd3201
*/

$title = "Profile Search Results";
$banner ="Profile Search Results";

$description ="Users can search for other users by filtering profiles. This page will display the results.";
			
$filename = "profile-search-results.php";

include("header.php");

$conn = db_connect();


if(isset($_SESSION['matchedUsers']))
{
	$users = $_SESSION['matchedUsers'];
	if((count($users)) == 1)
	{
		header('Location:profile-display.php');
		$_SESSION['display_user'] = $users[0];
	}
	elseif((count($users)) == 0)
	{
		echo "No Matches. Try opening up your search criteria.";
		echo "<a href=./profile-search.php</a>";
	}
	else
	{
		$num_pages = ceil((count($users)) / MAX_USERS_PER_PAGE);
		if(isset($_GET['min']) && ($_GET['min'] != 0))
		{
			echo "<a href=./profile-search-results.php?min=".($_GET['min']-10)."&max=".($_GET['max']-10).">&laquo;</a>         ";
		}
		for($page=1;$page<=$num_pages;$page++)
		{
			if($page==1)
			{
				$min = 0;
				$max = (MAX_USERS_PER_PAGE-1);
			}
			else
			{
				$min = $max+1;
				$max += (MAX_USERS_PER_PAGE);
			}
		
			echo "<a href=./profile-search-results.php?min=".$min."&max=".$max.">".$page."</a>         ";
		}
		if(isset($_GET['max']) && ($_GET['max'] <= count($users)))
		{
			echo "<a href=./profile-search-results.php?min=".($_GET['min']+10)."&max=".($_GET['max']+10).">&raquo;</a>         ";
		}
		elseif(!isset($_GET['max']))
		{
			echo "<a href=./profile-search-results.php?min=".(MAX_USERS_PER_PAGE)."&max=".(MAX_USERS_PER_PAGE+(MAX_USERS_PER_PAGE-1)).">&raquo;</a>         ";
		}
		
		echo "</br>";
		if(isset($_GET['max']) && isset($_GET['min']))
		{
			$min=$_GET['min'];
			$max=$_GET['max'];
			if($max>(count($users)))
			{
				$max=(count($users))-1;
			}
		}
		else
		{
			$min = 0;
			$max=0;
			$max = (MAX_USERS_PER_PAGE-1);
		}

		for($i=$min;$i<=$max;$i++)
		{
			$userId = $users[$i]['user_id'];
			createProfilePreview($userId);
		}
		
		echo "</br>";
		if(isset($_GET['min']) && ($_GET['min'] != 0))
		{
			echo "<a href=./profile-search-results.php?min=".($_GET['min']-10)."&max=".($_GET['max']-10).">&laquo;</a>         ";
		}
		for($page=1;$page<=$num_pages;$page++)
		{
			if($page==1)
			{
				$min = 0;
				$max = (MAX_USERS_PER_PAGE-1);
			}
			else
			{
				$min = $max+1;
				$max += (MAX_USERS_PER_PAGE);
			}
		
			echo "<a href=./profile-search-results.php?min=".$min."&max=".$max.">".$page."</a>         ";
		}
		if(isset($_GET['max']) && ($_GET['max'] <= count($users)))
		{
			echo "<a href=./profile-search-results.php?min=".($_GET['min']+10)."&max=".($_GET['max']+10).">&raquo;</a>         ";
		}
		elseif(!isset($_GET['max']))
		{
			echo "<a href=./profile-search-results.php?min=".(MAX_USERS_PER_PAGE)."&max=".(MAX_USERS_PER_PAGE+(MAX_USERS_PER_PAGE-1)).">&raquo;</a>         ";
		}
	 
	}
}
else
{
	echo "No matches found...why don't you try some different options...";
}

include("footer.php");
?>