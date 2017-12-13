<?php
require_once 'Includes/PageData.inc';
$page = new PageData(); //Create single instance of class

//Set the heading/title & other custom data for this page
$page->title = "My Budget Buddy";

//Check whether they're signed in. If they're not signed in and this is an admin page, kick em out!
require_once 'Includes/SessionCheck.inc';
require_once 'Includes/ContentLoader.inc';
?>
<!DOCTYPE html>
<html lang="en">

<!-- include file for header information -->
<head><?php include("header.inc"); ?></head>

<body>
	<!-- include file for the navbar and banner-->
	<?php include("navbar.inc"); ?>
	<?php include("banner.inc"); ?>

	<div class="indexSections">

		<div class="budgetIndex">

		<div class="sectionImg">
		<a href="budgetPlanner.php"><img src="img/icons/coins.png" class="indxImg" alt="Coin Icon" height="200" width="200"></a>
		</div>

		<h2>Budget Planner</h2>
        <?php echo GetContent(3); ?>

		</div><!-- end budgetInfo -->
		
		<div class="insturctionsIndex">
		
		<div class="sectionImg">
		<a href="instructions.php"><img src="img/icons/qmark.png" class="indxImg" alt="Help Icon" height="200" width="200"></a>
		</div>
		
		<h2>Instructions</h2>

        <?php echo GetContent(4); ?>
		</div><!-- end insturctionsIndex -->
		
		<div class="serviceProvidersIndex">
		
		<div class="sectionImg">
		<a href="contactUs.php"><img src="img/icons/peeps.png" class="indxImg" alt="People Icon" height="200" width="200"></a>
		</div>
		
		<h2>Contact Us</h2>

        <?php echo GetContent(5); ?>
		</div><!-- end serviceProvidersIndex -->

	</div> <!-- end indexSections -->

	<!-- include file for footer information -->
	<?php include("footer.inc"); ?>
</body>
</html>
