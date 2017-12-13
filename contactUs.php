<?php
require_once 'Includes/PageData.inc';
$page = new PageData(); //Create single instance of class

//Set the heading/title & other custom data for this page
$page->title = "Contact Us";

//Check whether they're signed in. If they're not signed in and this is an admin page, kick em out!
require_once 'Includes/SessionCheck.inc';
require_once 'Includes/ContentLoader.inc';
?>
<!DOCTYPE html>
<html lang="en">

<!-- include file for header information -->
<head><?php include("header.inc"); ?></head>
	
<body>
<!-- include file for the navbar -->
<?php include("navbar.inc"); ?>
<?php include("banner.inc"); ?>

<div class="instructionsContainer">

	<div class="instructionImg">
		<img src="img/icons/peeps.png" alt="Help Icon" height="175" width="175" class="">
	</div>

	<h2>Contact Information</h2>

	<div class="contactPadding">

		<h3>Endeavour Foundation Details</h3>
		<?php echo GetContent(7) ?>

	</div>
</div>
<?php include("footer.inc"); ?>
</body>
</html>