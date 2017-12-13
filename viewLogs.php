<?php
require_once 'Includes/PageData.inc';
$page = new PageData();
$page->title = "View Logs";
$page->adminOnly = true;
//$page->useBootstrap = false;
require_once 'Includes/SessionCheck.inc';

require_once 'Includes/Functions.inc';

?>
<html lang="en">
<head><?php include("header.inc"); ?></head>
<body>
<?php include("navbar.inc"); ?>
<div class="container">
    <h1>View Logs</h1>
    <ol class="breadcrumb">
        <li><a href="account.php">Account</a></li>
        <li><a href="admin.php">Admin</a></li>
        <li class="active">View Logs</li>
    </ol>
    <table id="tblLog" class="cell-border display compact">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Type</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
<?php
foreach (GetAllLogs() as $log) {
    echo "<tr>";
    echo "<td>$log->id</td>";
    echo "<td>$log->date</td>";
    echo "<td>$log->type</td>";
    echo "<td>$log->title</td>";
    echo "<td>$log->descr</td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>
<?php
include 'footer.inc';
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

<script type="text/javascript">
$('#tblLog').DataTable({
    "order": [[1, "desc"]],
    "pageLength": 25
});
</script>

</body>
</html>
