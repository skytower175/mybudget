<?php
require_once 'Includes/PageData.inc';
$page = new PageData();
$page->title = "Edit Content Page";
$page->adminOnly = true;
require_once 'Includes/SessionCheck.inc';

require_once 'Includes/Functions.inc';
require_once 'Includes/ContentLoader.inc';
require_once 'Includes/BudgetItemLoader.inc';

$id = isset($_GET["id"]) ? $_GET["id"] : null;
$contClass = null;
if ($id != null) {
    $contClass = GetContentClass($id);
    $page->title = "Edit Content - $contClass->name";
}

if (isset($_POST['submit'])) {
    UpdateContent($id, $_POST['content']);
}
?>
<html lang="en">
<head><?php include("header.inc"); ?></head>
<body>
<?php include("navbar.inc"); ?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<div class="container">
    <?php if ($id == null) {
    ?>
    <h1>Edit Content</h1>
    <ol class="breadcrumb">
        <li><a href="account.php">Account</a></li>
        <li><a href="admin.php">Admin</a></li>
        <li class="active">Edit Content</li>
    </ol>
    <?php
    echo '<table class="table table-hover" style="background-color: white;">';
    echo '<thead class="thead-default"><tr>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Description</th>';
        echo '<th>Last Modified</th>';
        echo '<th>Link</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach (GetAllContent() as $cont) {
            echo '<tr>';
            echo "<td>$cont[0]</td>";
            echo "<td>$cont[1]</td>";
            echo "<td>$cont[2]</td>";
            echo "<td>$cont[4]</td>";
            echo "<td><a href='editContent.php?id=$cont[0]'>Edit</a></td>";
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "<h1>Edit Content - $contClass->name</h1>";
        ?>
        <ol class="breadcrumb">
            <li><a href="account.php">Account</a></li>
            <li><a href="admin.php">Admin</a></li>
            <li><a href="editContent.php">Edit Content</a></li>
            <li class="active"><?php echo "$contClass->name" ?></li>
        </ol>
        <h2>Current</h2>
        <div style="background-color:white; padding: 5px;">
            <?php echo GetContent($id); ?>
        </div>
        <h2>Editor</h2>
        <form name="submit" method="post" action="editContent.php?id=<?php echo $id; ?>">
            <script>tinymce.init({selector: 'textarea', paste_use_dialog : false,
                    paste_auto_cleanup_on_paste : true,
                    paste_convert_headers_to_strong : false,
                    paste_strip_class_attributes : "all",
                    paste_remove_spans : true,
                    paste_remove_styles : true,
                    paste_retain_style_properties : "",});</script>
            <textarea id="content" name="content"><?php echo GetContent($id); ?></textarea>
            <br/>
            <button name="submit" type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
        </form>
    <?php } ?>
</div>
<?php
include 'footer.inc';
?>
</body>
</html>
