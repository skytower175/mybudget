<?php
require_once 'Includes/PageData.inc';
$page = new PageData(); //Create single instance of class

//Set the heading/title & other custom data for this page
$page->title = "Instructions";

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
			<img src="img/icons/qmark.png" alt="Help Icon" height="175" width="175">	
		</div>
	<div class="instructionsSection">
		<h2>Instructions</h2>
	</div><!-- end instructions-->
	
	<div class="NDISSection">
		<h3>Need some information on the NDIS?</h3>

		<?php echo GetContent(2); ?>
	</div><!-- end NDIS-->
	
	<div class="FAQSection">
		<h2>FAQ</h2>
		
			<div class="panel-group instructGroup" id="accordion">
				  <div class="panel panel-default">
				    <div class="panel-heading instPanel">
				      <h4 class="panel-title instinst">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
				        Is there an easy way to plan my budget?</a>
				      </h4>
				    </div>
				    <div id="collapse1" class="panel-collapse collapse">
				      <div class="panel-body">There is! Simply visit the budget planner page and click on the big CLICK ME 
						text at the top of the page. It will open our Budget Wizard where you can answer
						some simple questions that will help fill the planner out for you.</div>
				    </div>
				  </div>


				  <div class="panel panel-default instPanel">
				    <div class="panel-heading instPanel">
				      <h4 class="panel-title instinst">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
				        What is the coloured Endeavour items?</a>
				      </h4>
				    </div>
				    <div id="collapse2" class="panel-collapse collapse">
				      <div class="panel-body">The coloured items in the budget planner are services provided by the
						  Endeavour Foundation. If you would only like services via the Endeavour Foundation only fill
					 	 in these items.</div>
				    </div>


				  </div>
				  <div class="panel panel-default instPanel">
				    <div class="panel-heading instPanel">
				      <h4 class="panel-title instinst">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
				        Can I print out my budget plan?</a>
				      </h4>
				    </div>
				    <div id="collapse3" class="panel-collapse collapse">
				      <div class="panel-body">Yes! it's as simple as pressing the printer symbol at the top of the
						  planner after you have filed out your budget.</div>
				    </div>
				  </div>


				<div class="panel panel-default">
					<div class="panel-heading instPanel">
						<h4 class="panel-title instinst">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
								Can I contact the Endeavour Foundation</a>
						</h4>
					</div>
					<div id="collapse4" class="panel-collapse collapse">
						<div class="panel-body">Yes you can. Just visit the contact us page and fill out the
						form.</div>
					</div>
				</div>


					<div class="panel panel-default">
						<div class="panel-heading instPanel">
							<h4 class="panel-title instinst">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
									Is there a way to easily view my spendings?</a>
							</h4>
						</div>
						<div id="collapse5" class="panel-collapse collapse">
							<div class="panel-body">Under the summary tab in the budget planner there is a pie
								chart that will display your spendings in an easily understandable format.</div>
						</div>
					</div>
				</div>

	</div><!-- end FAQ-->
	</div><!-- end container-->
	<!-- include file for footer information -->
	<?php include("footer.inc"); ?>
</body>
</html>
