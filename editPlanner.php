<?php
require_once 'Includes/PageData.inc';
$page = new PageData();
$page->title = "Edit Budget Planner Items";
$page->adminOnly = true;
//$page->useBootstrap = false;
require_once 'Includes/SessionCheck.inc';

require_once 'Includes/BudgetItemLoader.inc';
require_once 'Includes/EditPlanner.inc';
require_once 'Includes/Functions.inc';

$items = array();
$items = BudgetItemLoader::GetBudgetItems();
if (isset ($_POST ['upload'])) {
    $items = GetItemsFromCSV();
    if (sizeof($items) > 0){
        BudgetItemLoader::UploadNewBudgetItems($items);
        WriteLog('editplanner', "User '$currUser->username' truncated and uploaded new items");
    }
    else {
        WriteLog('editplanner', 'update failed');
    }
}

$categories = BudgetItemLoader::GetCategoriesFromItems($items);
?>
<html lang="en">
<head><?php include("header.inc"); ?></head>
<body>
<?php include("navbar.inc"); ?>
<div class="container">
    <h1>Edit Budget Planner</h1>
    <ol class="breadcrumb">
        <li><a href="account.php">Account</a></li>
        <li><a href="admin.php">Admin</a></li>
        <li class="active">Edit Planner</li>
    </ol>
    <h2>CSV Upload</h2>
    <div class="panel panel-default">
        <div class="panel-body">
            <p>CSV is available
                <a href="https://www.ndis.gov.au/2015-price-guide-vic-nsw-tas" target="_blank">here</a>.</p>
            <p>Click <a role="button" data-toggle="collapse" href="#collapseColumns" aria-expanded="false"
                        aria-controls="collapseColumns">here</a> to show which columns the CSV requires.</p>
            <div id="collapseColumns" class="collapse">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Example</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Support Cluster</td>
                        <td>String</td>
                        <td>The name of the cluster that this belongs to.</td>
                        <td>Accommodation/Tenancy</td>
                    </tr>
                    <tr>
                        <td>Support Item</td>
                        <td>String</td>
                        <td>The name of the item.</td>
                        <td>assistance with accommodation and tenancy obligations</td>
                    </tr>
                    <tr>
                        <td>Support Item Ref No</td>
                        <td>String</td>
                        <td>The reference number of the item.</td>
                        <td>01 001</td>
                    </tr>
                    <tr>
                        <td>Support Item Description</td>
                        <td>String</td>
                        <td>Description of the item.</td>
                        <td>Support is provided to guide, prompt, or undertake activities to ensure the participant
                            obtains/retains appropriate accommodation. May include assisting to apply for a rental
                            tenancy
                            or to undertake tenancy obligations.
                        </td>
                    </tr>
                    <tr>
                        <td>Unit of Measure</td>
                        <td>String</td>
                        <td>The unit of measure to quantify the support item.</td>
                        <td>Hour</td>
                    </tr>
                    <tr>
                        <td>Quote Required</td>
                        <td>Y/N</td>
                        <td>Whether or not a quote is required.</td>
                        <td>N</td>
                    </tr>
                    <tr>
                        <td>List Price</td>
                        <td>Price</td>
                        <td>Price of the item (per unit of measure).</td>
                        <td>$55.50</td>
                    </tr>
                    <tr>
                        <td>Support Categories</td>
                        <td>String</td>
                        <td>Name of the category it belongs to.</td>
                        <td>Improved living arrangements</td>
                    </tr>
                    <tr>
                        <td>Support Category Number</td>
                        <td>Int</td>
                        <td>ID of the category it belongs to.</td>
                        <td>8</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <form method="post" action="editPlanner.php"
                  enctype="multipart/form-data">
                <input type="file" name="csvfile" id="csvfile"/>
                <br/>
                <input type="submit" class="btn btn-primary" name="upload" value="Submit CSV"/>
            </form>
        </div>
    </div>
    <?php
    if (count($items) > 0 && false) {
        ?>
    <h2>Budget Categories</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($categories as $category) {
                echo '<tr>';
                echo "<td>$category->id</td>";
                echo "<td>$category->name</td>";
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <?php
    if (count($items) > 0) {
        ?>
    <h2>Budget Items</h2>
    <div id="dvLoading">Table is loading...</div>
        <table id="tblItems" class="cell-border display compact" cellspacing="0" width="100%" style='visibility:hidden;'>
            <thead>
            <tr>
                <th>ID</th>
                <th>Cluster</th>
                <th>Name</th>
                <th>Description</th>
                <th>Units</th>
                <th>Quote?</th>
                <th>Price</th>
                <th>Category</th>
                <th>Sponsored</th>
                <th>Update</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($items as $item) {
                echo "<tr class='edit-row'>";
                echo "<td data-name='idStr'><span class='orig'>$item->idStr</span></td>";
                echo "<td data-name='cluster'><span class='orig'>$item->cluster</span></td>";
                echo "<td data-name='name'><span class='orig'>$item->name</span></td>";
                echo "<td data-name='description'><span class='orig'>$item->description</span></td>";
                echo "<td class='smaller' data-name='unit'><span class='orig'>$item->unitMeasure</span></td>";
                $quoteText = $item->quoteRequired ? "Yes" : "No";
                echo "<td class='smaller' data-name='quote' data-val='$item->quoteRequired'><span class='orig'>$quoteText</span></td>";
                $priceText = '$' . $item->price;
                echo "<td class='smaller' data-name='price' data-val='$item->price'><span class='orig'>$priceText</span></td>";
                echo "<td data-name='category' data-val='$item->categoryId'><span class='orig'>($item->categoryId) $item->categoryName</span></td>";
                $sponsorText = $item->sponsored ? "Yes" : "No";
                echo "<td class='smaller' data-name='sponsored' data-val='$item->sponsored'><span class='orig'>$sponsorText</span></td>";
                // All that misc. stuff
                echo "<td data-name='controls'>";
                //echo "<input type='hidden' name='tochange' value='0' />";
                echo "<button type='button' name='edit' value='Edit' class='btn btn-default' onclick='enterEdit(this);'>";
                echo "<span class='rowicon glyphicon glyphicon-pencil'></span>Edit";
                echo "</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    <?php } ?>
</div>
<?php
include 'footer.inc';
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

<script type="text/javascript" src="js/editPlanner.js"></script>

<style>
    .disabled {
        color: #999;
    }

    td {word-wrap: break-word;}

    table tr select {
        max-width: 250px;
    }

    .smaller input {
        width: 100px;
    }

    /*tr.inedit {
        background-color: yellow !important;
    }*/

    #tblItems {
        /*     table-layout:fixed; */
    }

    span.rowicon {
        margin-right:5px;
    }

</style>
</body>
</html>
