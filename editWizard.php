<?php
require_once 'Includes/PageData.inc';
$page = new PageData();
$page->title = "Edit Wizard";
$page->adminOnly = true;
//$page->useBootstrap = false;
require_once 'Includes/SessionCheck.inc';

require_once 'Includes/BudgetItemLoader.inc';
require_once 'Includes/EditPlanner.inc';
require_once 'Includes/WizardLoader.inc';
require_once 'Includes/Functions.inc';

$wizardItems = WizardLoader::GetWizardItems();

?>
<html lang="en">
<head><?php include("header.inc"); ?></head>
<body>
<?php include("navbar.inc"); ?>
<div class="container">
    <h1>Edit Wizard Questions</h1>
    <ol class="breadcrumb">
        <li><a href="account.php">Account</a></li>
        <li><a href="admin.php">Admin</a></li>
        <li class="active">Edit Wizard</li>
    </ol>
    <div id="divControls" class="row">
        <div class="col-xs-4">
            <select id="slctWiz" size="10"></select>
        </div>
        <div id="controlsBox" class="col-xs-8">
            <div>
                <input type="text" id="txtName" />
                <input type="button" class="btn btn-default" id="btnSaveName" value="Change Name" />
            </div>
            <div>
                <input type="button" class="btn btn-default" id="btnMoveUp" value="Move Up" />
                <input type="button" class="btn btn-default" id="btnMoveDown" value="Move Down" />
            </div>
            <div>
                <input type="button" class="btn btn-primary" id="btnNew" value="New" />
                <input type="button" class="btn btn-danger" id="btnDelete" value="Delete" />
                <input type="button" class="btn btn-success" id="btnSaveAll" value="Save All" />
            </div>
        </div>
    </div>
    <div id="divButtons" class="form-group row">
        <div class="col-xs-5">
            <select id="slctInclude" size="10" class="swapBox"></select>
        </div>
        <div class="col-xs-2" style="text-align:center;">
            <button type="button" class="btn btn-default" id="btnLeft">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
            <button type="button" class="btn btn-default" id="btnRight">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </button>
        </div>
        <div class="col-xs-5">
            <select id ="slctRemaining" size="10" class="swapBox"></select>
        </div>
    </div>
    <!-- end content -->
</div>
<?php
include 'footer.inc';
?>

<script type="text/javascript">
var budgetItems = <?php echo json_encode(BudgetItemLoader::GetBudgetItems()); ?>;
var wizardItems = <?php echo json_encode(WizardLoader::GetWizardItems()); ?>;
</script>

<script type="text/javascript" src="js/editWizard.js"></script>

<style type="text/css">
select {
    /*width:300px;*/
    width:100%;
}
.row div {
    padding:5px;
}
<style>

</body>
</html>
