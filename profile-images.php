<?php
# profile-images.php
/*
Name: Group 05
File:  profile-images.php
Date: 2017-11-21
Description : This is where the user will be able to upload a profile image
Course: Webd3201
*/

$title ="Upload your profile Image";
$banner ="Upload your profile Image!";
$description ="This is where the user will be able to upload a profile image";			
$filename = "profile-images.php";
include "header.php"; # bring in the header file containing a nav bar, description, heading
$conn = db_connect();
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true)
{
	if (trim($_SESSION['user_type']) == CLIENT || trim($_SESSION['user_type']) == ADMIN)
	{
		$numImages= $_SESSION['images'];
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if($numImages==0 && !is_dir("images/".$_SESSION['user_id']))
			{
				mkdir("images/".$_SESSION['user_id']);
			}
			# file upload
			if(isset($_FILES['fileToUpload']) && ($_POST['deleteImage'])=="")
			{
				if($_FILES['fileToUpload']['error'] != 0)
				{
					echo "<h2>There was an issue uploading your file.</h2>";
				}
				else if($_FILES['fileToUpload']['size'] > MAX_FILE_SIZE)
				{
					echo "<h2>The file you selected is to big.</h2>";
				}
				else if($_FILES['fileToUpload']['type'] != "image/jpeg" && $_FILES['fileToUpload']['type'] != "image/pjpeg")
				{
					echo"<h2>All profile pictures must be uploaded as JPG</h2>";
				}
				else
				{
					$_SESSION['images'] += 1;
					$tmpName=$_FILES['fileToUpload']['tmp_name'];
					$name = basename($_FILES['fileToUpload']['name']);
					$destination = "images/".$_SESSION['user_id']."/".$name;
					$newName = "images/".$_SESSION['user_id']."/".$_SESSION['user_id']."_".$_SESSION['images'].".jpg";
					if(move_uploaded_file($tmpName,$destination))
					{
						rename($destination, $newName);
					}
				}
				
			}
			else if(!empty($_POST['deleteImage']))
			{
				foreach($_POST['deleteImage'] as $pic)
				{ 
					$path = "images/".$_SESSION['user_id']."/".$_SESSION['user_id']."_".$pic.".jpg";
					unlink($path);
					if($_SESSION['images'] - 1 == 0)
					{
						rmdir("images/".$_SESSION['user_id']);
					}
					$_SESSION['images'] -= 1;		
				}
					
			}
			# setting main image
			if(isset($_POST['mainImage']))
			{
				$pic = $_POST['mainImage'];
				$newMainPath = "images/".$_SESSION['user_id']."/".$_SESSION['user_id']."_".$pic.".jpg";
				$oldMainPath = "images/".$_SESSION['user_id']."/".$_SESSION['user_id']."_1.jpg";
				$tempName = "images/".$_SESSION['user_id']."/".$_SESSION['user_id']."_temp.jpg";
				rename($oldMainPath,$tempName);
				rename($newMainPath,$oldMainPath);
				rename($tempName,$newMainPath);
			}

			#$result = pg_execute($conn,"query_update_user_images",array($numImages, $_SESSION['user_id']));
		}

		?>
		<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">

		<!-- Banner -->
		<section id="one" class="wrapper style1 special">
				<header>
					<h3>Upload your Profile Images</h3>
					<div class="inner">
						<div class="box person">
							<div class="image round">
								<img src="<?php echo "images/".$_SESSION['user_id']."/".$_SESSION['user_id']."_1.jpg";?>" alt="Image" />
								<input id="delete1" type="checkbox" name="deleteImage[]" value="1"/>
								<label for="delete1"> Delete</label>
							</div>
						</div>
					</div>
				</header>

			<div class="inner">
				<div class="flex flex-4">
			<?php
					if($numImages > 1)
					{
						for($pic=2;$pic<=$numImages;$pic++)
						{
			?>	
						
							<div class="box person">
								<div class="image round">
									<img src="<?php echo "images/".$_SESSION['user_id']."/".$_SESSION['user_id']."_".$pic.".jpg";?>" alt="Image" />
									<input id="<?php echo "main".$pic; ?>" type="radio" name="mainImage" value="<?php echo $pic ;?>" />
									<label for="<?php echo "main".$pic; ?>"> Set as main</label>
									<input id="<?php echo "delete".$pic; ?>" type="checkbox" name="deleteImage" value="<?php echo $pic ;?>" />
									<label for="<?php echo "delete".$pic; ?>"> Delete</label>
								</div>
							</div>
			
			<?php 
						}
			?>
				</div>
			</div>	
				<div class="inner">
					<div class="flex flex-3">
						<article>
							<h3>Select an image to upload</h3>
							
				<?php
					}
					
			if($numImages==0 || $numImages < MAX_NUMBER_OF_IMAGES)
			{
			?>	
							<div class="6u$ 12u$(xsmall)">
								<input type="file" name="fileToUpload" id="fileToUpload" size="50"/>
							</div>	
			<?php
			}
			else
			{
				echo "You have uploaded the maximum number of images. PLease delete one or more to upload more.";
			}
			?>
							<footer>
								<input type="submit" value="Submit" class="button special"/>
							</footer>
						</article>
					</div>
				</div>
		</section>
		</form>

<?php
	}
}
else
{
	header("Location:user-login.php");
}
include "footer.php";
?>
