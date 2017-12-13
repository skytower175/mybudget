	<!-- Static-Top Navbar -->
	<nav class="navbar navbar-inverse nav-fixed-top" id="my-navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div><!-- End navbar Header-->
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Home</a>
					<li><a href="contactUs.php">Contact Us</a>
					<li><a href="budgetPlanner.php">Budget Planner</a>
					<li><a href="instructions.php">Instructions</a>
					<li><a href="https://myplace.ndis.gov.au" target="_blank">NDIS</a>
					<?php
						if ($signed_in)
							echo "<li><a href='admin.php' id='adminNav'><span class='glyphicon glyphicon-user' aria-hidden='true'></span>$currUser->username</a></li>"
					?>
				</ul>
			</div><!-- End collapse Navbar -->
		</div><!-- End container -->
	</nav><!-- End Navbar -->
	<div class="orangeLine">
	</div>