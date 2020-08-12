<?php
/*
Name: Group 05
File: disabled-users.php
Date: 2017-01-11
Description : Where disabled users are displayed
Course: Webd3201
*/

$title = "Dashboard";
?>

<?php 
	include 'header.php';
	$conn = db_connect();
	#Output personalized message
	$welcome_message = "Welcome ADMINISTRATOR " . $_SESSION['first_name'] . " " . $_SESSION["last_name"] . "!";
	$last_accessed_message = "Last Access: " . $_SESSION['last_accessed'];
?>

        <!-- Banner -->
            <section id="banner">
                <h1><?php echo $welcome_message; ?></h1>
                <h4><?php echo $last_accessed_message; ?></h4>
            </section>

		<!-- Scrolling Pre heading -->
			<section id="two" class="wrapper style1 special">
				<div class="inner">
					<header>
						<h2>Disabled Users</h2>
						
					</header>
				</section>

						<?php
						$result = pg_query($conn, "SELECT user_id FROM users WHERE user_type = 'D'");
						if (pg_num_rows($result)>0)
						{
							$users = pg_fetch_all($result);
							$num_pages = ceil((count($users)) / MAX_USERS_PER_PAGE);
							if(isset($_GET['min']) && ($_GET['min'] != 0))
							{
								echo "<a href=./disabled-users.php?min=".($_GET['min']-10)."&max=".($_GET['max']-10).">&laquo;</a>         ";
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
							
								echo "<a href=./disabled-users.php?min=".$min."&max=".$max.">".$page."</a>         ";
							}
							if(isset($_GET['max']) && ($_GET['max'] <= count($users)))
							{
								echo "<a href=./disabled-users.php?min=".($_GET['min']+10)."&max=".($_GET['max']+10).">&raquo;</a>         ";
							}
							elseif(!isset($_GET['max']))
							{
								echo "<a href=./disabled-users.php?min=".(MAX_USERS_PER_PAGE)."&max=".(MAX_USERS_PER_PAGE+(MAX_USERS_PER_PAGE-1)).">&raquo;</a>         ";
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
								echo "<a href=./disabled-users.php?min=".($_GET['min']-10)."&max=".($_GET['max']-10).">&laquo;</a>         ";
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
							
								echo "<a href=./disabled-users.php?min=".$min."&max=".$max.">".$page."</a>         ";
							}
							if(isset($_GET['max']) && ($_GET['max'] <= count($users)))
							{
								echo "<a href=./disabled-users.php?min=".($_GET['min']+10)."&max=".($_GET['max']+10).">&raquo;</a>         ";
							}
							elseif(!isset($_GET['max']))
							{
								echo "<a href=./disabled-users.php?min=".(MAX_USERS_PER_PAGE)."&max=".(MAX_USERS_PER_PAGE+(MAX_USERS_PER_PAGE-1)).">&raquo;</a>         ";
							}
						 
						}

						?>
							
					</div>
				</div>

        <!-- Footer -->
    <?php include('footer.php') ?>