<?php
require_once 'Includes/PageData.inc';
$page = new PageData();
$page->title = "Admin Landing Page";
$page->adminOnly = true;
require_once 'Includes/SessionCheck.inc';

require_once 'Includes/Functions.inc';
require_once 'Includes/BudgetItemLoader.inc';
require_once 'Includes/ContentLoader.inc';
$page->title = "Admin tools";
?>
<html lang="en">
<head><?php include("header.inc"); ?></head>
<body>
<?php include("navbar.inc"); ?>
<div class="container">
    <h1>Admin Tools</h1>
    <ol class="breadcrumb">
        <li><a href="account.php">Account</a></li>
        <li class="active">Admin</li>
    </ol>
    <?php echo GetContent(9) ?>
    <ul class="list-group">
        <li class="list-group-item">This site is for: <?php echo getenv('SITE_LOC'); ?></li>
    </ul>
    <div class="list-group">
        <a class="list-group-item" href="editPlanner.php"><span class="glyphicon glyphicon-th-list" aria-hidden="true" style='padding-right:5px;'></span>Edit Planner</a>
        <a class="list-group-item" href="editWizard.php"><span class="glyphicon glyphicon-th-large" aria-hidden="true" style='padding-right:5px;'></span>Edit Wizard</a>
        <a class="list-group-item" href="editContent.php"><span class="glyphicon glyphicon-book" aria-hidden="true" style='padding-right:5px;'></span>Edit Content</a>
        <a class="list-group-item" href="viewLogs.php"><span class="glyphicon glyphicon-console" aria-hidden="true" style='padding-right:5px;'></span>View Logs</a>
        <a class="list-group-item" href="account.php"><span class="glyphicon glyphicon-user" aria-hidden="true" style='padding-right:5px;'></span>Account Page</a>
    </div>
</div>

<?php
include 'footer.inc';
?>

</body>
</html>
