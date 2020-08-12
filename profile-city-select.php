
<?php
/*
Name: Group 05
File: profile-city-select.php
Date: 2017-12-12
Description : This page will allow a user to search an area for other users
Course: Webd3201
*/
$title = "Profile City Select";
$banner ="Profile City Select";

$description ="This is the Profile city select page.";
			
$filename = "profile-city-select.php";
include "header.php"; # bring in the header file containing a nav bar, description, heading
?>
<section id="banner"><h1><?php echo $banner;?></h1></section>
<script type="text/javascript">
	function cityToggleAll()
	{
		//alert("In cityToggleAll()");
		var isChecked = document.getElementById('city_toggle').checked;
		var city_checkboxes = document.getElementByName('city[]');
		for(var i in city_checkboxes)
		{
			city_checkboxes[i].checked = isChecked;
		}
		
	}
</script>

<?php
if(isset($_COOKIE['city']))
{
	$city = $_COOKIE['city'];
}	
else
{
	$city = 0;
}
if($_SERVER["REQUEST_METHOD"] == "GET"){

	$value = 0;
	$value = ($_GET['city']);
	$city += $value;

}else if($_SERVER["REQUEST_METHOD"] == "POST"){
	$city = sumCheckBox($_POST['city']);
	$_SESSION['city'] = $city;
	setcookie("city", $city, time() + SECONDS*DAYS);
	header('Location:profile-search.php');

}
?>
<!-- the form used for input -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<!-- buttons -->
	<table border="0" cellspacing="15" >
		<tr>
		<div class="4u 12u$(small)">
		
		<h2>Cities</h2>
		<input type="checkbox"  id="city_toggle" onclick="cityToggleAll();" name="city[]" value="0"><label for='city_toggle'>Select All</label><br/>
		<?php buildCheckBox('city', $city); ?>

		</div>
		</tr>

	</table>
	
	<map name="citymap">
		<!-- Ajax -->
		<area shape="poly" href="./profile-city-select.php?city=1" coords="151,307,261,235,425,458,426,465,421,476,416,483,379,490,367,504,366,511,356,518,346,520,334,530,332,536,313,531,293,531,291,534,270,531,199,441,185,451,153,406,197,374," alt="Ajax"/>
		<!-- Brooklin -->
		<area shape="poly" href="./profile-city-select.php?city=2" coords="372,241,419,205,448,283,436,252,443,262,443,272,426,274,418,277,410,269,399,275" alt="Brooklin"/>
		<!-- Bowmanville -->
		<area shape="poly" href="./profile-city-select.php?city=4" coords="583,212,694,133,779,239,779,244,771,250,767,274,763,278,753,279,746,284,732,301,732,305,727,310,711,311,704,310,693,316,676,316,667,317," alt="Bowmanville"/>
		<!-- Oshawa -->
		<area shape="poly" href="./profile-city-select.php?city=8" coords="385,152,480,89,663,320,649,332,634,329,634,337,639,344,630,346,634,353,625,364,591,382,554,382,384,151" alt="Oshawa"/>
		<!-- Pickering -->
		<area shape="poly" href="./profile-city-select.php?city=16" coords="15,396,146,309,192,373,145,407,184,457,198,448,265,535,263,539,270,550,265,550,261,547,251,548,246,556,246,593,243,600,235,595,221,592,200,593,200,597,187,582,170,583,154,581,144,576,136,576,131,571," alt="Pickering"/>
		<!-- Port Perry -->
		<area shape="poly" href="./profile-city-select.php?city=32" coords="321,71,416,7,477,83,383,146" alt="Port Perry">
		<!-- Whitby -->
		<area shape="poly" href ="./profile-city-select.php?city=64" coords="266,232,381,154,417,204,369,241,398,277,410,271,417,278,427,277,444,275,445,263,438,252,449,274,550,382,536,394,536,410,538,420,517,420,486,420,474,423,466,435,441,436,426,453," alt="Whitby"/>
	</map>
	<img src="images/map.png" width="794px" height="612px" alt="City Map" usemap="#citymap">

	<div>
		<input type="submit" value ="Search Area" class="special"/>
	</div>
</form>



<!-- end of main page content -->
<?php	
	include "footer.php"; # display the footer
?>