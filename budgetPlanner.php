<?php
require_once 'Includes/PageData.inc';
$page = new PageData(); //Create single instance of class

//Set the heading/title & other custom data for this page
$page->title = "Budget Planner";
$page->adminOnly = false; //This is false by default, so you can exclude this line for most pages.

//Check whether they're signed in. If they're not signed in and this is an admin page, kick em out!
require_once 'Includes/SessionCheck.inc';

require_once 'Includes/BudgetItemLoader.inc';

require_once('Includes/WizardLoader.inc');
$arr = WizardLoader::GetWizardItems();
$categories = BudgetItemLoader::GetCategoriesFromDB();
require_once 'Includes/ContentLoader.inc';
?>
<!DOCTYPE html>
<html lang="en">
<!-- include file for header information -->
<head><?php include("header.inc"); ?></head>
<body>
<!-- include file for the navbar -->
<?php include("navbar.inc"); ?>
<div class="bgContainer">
    <div class="budgetPlannerIntro">
        <h1>Budget Planner</h1>
        <?php echo GetContent(6) ?>
        <p><span class="fillBudgetBold">If you would like to answer some questions that will help us
            fill out your budget <a href="#" id="clickToWizard">CLICK HERE!</a></span>
        </p>
    </div>

    <?php include("wizardForm.inc"); ?>

    <div class="toolHeader">
        <h2>Planner Tool</h2>
        <input class="toolSearch" type="text" id="searchText" name="search" placeholder="Search.."/>
        <input type="hidden" id="wizardText" value=""/>
        <p><a id="printLink" href="#" class="bigblue">
                <img src="img/icons/print.png" alt="Printer" class="headerIcons">
                <span class="btncontainer">Print</span></a>
        </p>
        <p><a href="#" id="resetLink"><img src="img/icons/reset.png" class="headerIcons" alt="Reset">
                <span class="btncontainer">Reset</span></a></p>
    </div>
    <div class="budgetWrap">
        <div class="input-group input-group-lg">
            <span class="input-group-addon" id="sizing-addon1">NDIS budget amount:</span>
            <input type="text" class="form-control amount" id="txtInitial"
                   placeholder="Enter amount..." aria-describedby="sizing-addon1">
            <div class="budgetTotal">
                Total: <span id="spnTotal"></span>
            </div>
        </div>
        <?php
        foreach ($categories as $category) {
            ?>
            <div class="panel-group category-panel" role="tablist"
                 aria-multiselectable="true">
                <div class="panel panel-default"
                     style="border-left: 16px solid #<?php echo $category->colour; ?>; border-top: 3px solid #<?php echo $category->colour; ?>">
                    <div class="panel-heading" role="tab"
                         id="heading<?php echo $category->id; ?>">
                        <h4 class="panel-title">
                            <a class="collapsed budgetHead" role="button" data-toggle="collapse"
                               data-parent="#accordion" href="#collapse<?php echo $category->id; ?>"
                               aria-expanded="false"
                               aria-controls="collapse<?php echo $category->id; ?>">
                                <img src="<?php echo $category->image; ?>" class="budgetIcon" alt="budgetIcon" height="40"
                                     width="40">
                                <?php echo $category->name; ?></a>
                        </h4>
                    </div>
                    <div id="collapse<?php echo $category->id; ?>"
                         class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="heading<?php echo $category->id; ?>">
                        <div class="panel-body">
                            <div>
                                <?php
                                foreach (BudgetItemLoader::GetItemsByCategory($category->id) as $item) {
                                    $sponsclass = $item->sponsored ? 'sponsored' : '';
                                    echo "<div class='item-row $sponsclass'>";
                                    echo "<img src='img/endvSponsor.png' width='220' alt='Endeavour Sponsored' class='endvSpono'>";
                                    echo "<span class='idStuff'>";
                                    echo "<input type='hidden' name='id' value='$item->idStr' />";
                                    echo "<input type='hidden' name='price' value='$item->price' />";
                                    echo "<input type='hidden' name='category' value='$item->categoryId' />";
                                    echo "<input type='hidden' name='name' value='$item->name' />";
                                    echo "<span><strong>$item->refNo:</strong>&nbsp;$item->name</span>";
                                    if ($item->description != '' && sizeof($item->description) > 0){
                                        echo "<a data-toggle='collapse' class='budgetDescription' href='#collapseExample$item->idStr' aria-expanded='false' aria-controls='collapseExample$item->idStr'>
                                            Open Description
                                          </a>";
                                        echo "<span  class='collapse' id='collapseExample$item->idStr'>$item->description</span>";
                                    }
                                    echo "</span>";
                                    echo "<span>";
                                    echo "<input type='text' class='amount' placeholder='Enter Amount...'/>";
                                    echo "<span class='price'>&#36;$item->price / $item->unitMeasure </span>";
                                    echo "<span class='totalArea'>Spent = $<span class='total'>0</span></span>";
                                    echo "</span>";
                                    echo "";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class=panel-group role="tablist"
             aria-multiselectable="true">
            <div class="panel panel-default" style="border-left: 16px solid #004971; border-top: 3px solid #004971;">
                <div class="panel-heading" role="tab"
                     id="heading15">
                    <h4 class="panel-title">
                        <a class="collapsed budgetHead" role="button" data-toggle="collapse"
                           data-parent="#accordion" href="#collapse15"
                           aria-expanded="false"
                           aria-controls="collapse15">
                            <img src="img/icons/summary15.png" class="budgetIcon" alt="budgetIcon" height="40"
                                 width="40">
                            Summary</a>
                    </h4>

                    <div id="collapse15"
                         class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="heading15">

                        <div class="panel-body">
                            <div id="piechart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- include file for footer information -->
<?php include("footer.inc"); ?>
<div class="static_bar">

    <!-- So we need to get the value of remaining value/total input = percent - 1 = progress value
    then change the style if value is under70, under85 or over 85-->

    <div class="progress_bar">
        <p>Budget used:</p>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0"
                 aria-valuemin="0" aria-valuemax="70" id="success">
                <span class="progress_value"></span>
            </div>
        </div>
        <a class="collapsed btn btn-default" id="viewSummary" role="button" data-toggle="collapse"
           data-parent="#accordion" href="#collapse15"
           aria-expanded="false"
           aria-controls="collapse15">View Summary</a>
    </div>
</div>

<script type="text/javascript">
    var categories = <?php
        echo json_encode(BudgetItemLoader::GetCategoriesFromDB());
    ?>;
</script>

<script src="js/budgetPlanner.js" type="text/javascript"></script>

<script src="js/search.js"></script>
<script type="text/javascript">
var wizArray = <?php echo json_encode($arr); ?>;
</script>
<script src="js/wizard.js"></script>

</body>
</html>
