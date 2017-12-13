<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 31/10/2016
 * Time: 6:10 PM
 */

require_once 'Includes/PageData.inc';
require_once 'Includes/BudgetItemLoader.inc';
$page = new PageData(); //Create single instance of class

$page->title = "Budget Planner - Print Out";
$page->adminOnly = false;

require_once 'Includes/SessionCheck.inc';

$keys = array_keys($_GET);

//echo json_encode(array_keys($_GET));

$initial = 0;
$initial = floatval($_GET['in']);
$spent = 0;

$categories = array();
foreach(BudgetItemLoader::GetCategoriesFromDB() as $cat) {
    array_push($categories, array($cat->name, 0));
}

foreach($keys as $key){
    if ($key != "in") {
        $item = BudgetItemLoader::GetSingleItem($key);
        $quantity = $_GET[$key];
        $cost = $item->price * $quantity;
        $spent += $cost;
        //echo "<tr>";
        //echo "<td>$item->id</td>";
        //echo "<td>$item->name</td>";
        //echo "<td>$quantity</td>";
        //echo "<td>$cost</td>";
        //echo "</tr>";
    }
}

    //foreach($keys as $key){
    //$amount = $_GET[$key];
    //if ($key == "in"){
        //$inital = floatval($amount);
    //}
    //else {
        //$item = BudgetItemLoader::GetSingleItem($key);
        //echo "$item->name<br/>";
    //}
    ////echo "$key<br/>";
//}

//echo $inital;
$expenses = array();
$expenses = array_pad($expenses, count($categories), 0);
//echo json_encode($expenses);
?>

<!DOCTYPE html>
<html lang="en">
<!-- include file for header information -->
<head><?php include("header.inc"); ?></head>
<body>
<div class="container">

<h1>Budget Planner - Print Copy</h1>

<table class="table table-border">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="3">Initial Amount</td>
        <td><?php echo $initial; ?></td>
    </tr>
    <?php
    foreach($keys as $key) {
        if ($key != "in") {
            $item = BudgetItemLoader::GetSingleItem($key);
            $quantity = $_GET[$key];
            $cost = $item->price * $quantity;
            $expenses[$item->categoryId] += $cost;
            echo "<tr>";
            echo "<td>$item->id</td>";
            echo "<td>$item->name</td>";
            echo "<td>$quantity</td>";
            echo "<td>$cost</td>";
            echo "</tr>";
        }
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Spent</td>
            <td><?php echo $spent; ?></td>
        </tr>
        <tr>
            <td colspan="3">Total</td>
            <td><?php echo $initial - $spent; ?></td>
        </tr>
    </tfoot>
    
</table>
<div name="chartDiv" id="piechart"></div>
</div>

<?php include("footer.inc"); ?>

<script type="text/javascript">

var categories = <?php
    echo json_encode(BudgetItemLoader::GetCategoriesFromDB());
?>;
var expenses = <?php echo json_encode($expenses) ?>;
</script>

<script type="text/javascript">

google.charts.load("visualization", "1", {'packages': ['corechart'], "callback": drawChart});
google.charts.setOnLoadCallback(drawChart);
var chart;
//var expenses = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
function drawChart() {
    var tbl = [['Expense', 'Amount']];
    for (var i = 0; i < categories.length; i++) {
        tbl.push([categories[i].name, expenses[i]]);
    }
    tbl.push(['remaining', <?php echo $initial - $spent ?> ]);
    var data = google.visualization.arrayToDataTable(tbl);
    var options = {
title: 'expenses'
    };
    chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}

</script>

<style type="text/css">
body {
background-color:white;
}

div#piechart {
width:500px;
}

</style>

</body>
</html>
