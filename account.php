<?php
require_once 'Includes/PageData.inc';
$page = new PageData(); //Create single instance of class

//Set the heading/title & other custom data for this page
$page->title = "Account Page";
//Make sure you don't get confused with this being false. It means they are not signed in YET.
$page->adminOnly = false;

//Check whether they're signed in. If they're not signed in and this is an admin page, kick em out!
require_once 'Includes/SessionCheck.inc';

require_once 'Includes/ServerValidate.inc';

//Result of whichever action they take on this page
$actionResult = new Result();

/* Postback for register */
if (isset($_POST['register']) && false) {
    $username = FixInput($_POST['username']);
    $password = FixInput($_POST['password']);
    $actionResult = Register($username, $password);
    if ($actionResult->isError == false) {
        $actionResult = Login($username, $password);
        header("Location: account.php");
        exit();
    }
}

/* Postback for login */
if (isset($_POST['login'])) {
    $username = FixInput($_POST['username']);
    $password = FixInput($_POST['password']);
    $actionResult = Login($username, $password);
    header("Location: account.php");
    exit();
}

/* Postback for logout */
if ($signed_in && isset($_POST['logout'])) {
    session_destroy();
    header("Location: account.php");
    exit();
}


require_once 'Includes/Functions.inc';
require_once 'Includes/ContentLoader.inc';
?>

<html lang="en">
<head><?php include("header.inc"); ?></head>
<body>
<?php include("navbar.inc"); ?>
<div class="container">
    <h1>Account</h1>
    <ol class="breadcrumb">
        <li class="active">Account</li>
    </ol>
    <?php echo GetContent(8) ?>
    <?php
    if ($actionResult->message != null) {
        $alertType = $actionResult->isError ? 'alert-danger' : 'alert-success';
        echo "<div class='alert $alertType' role='alert'>$actionResult->message</div>";
    }
    if ($signed_in == true) {
        if ($currUser->admin == true){
            ?>
            <div>
                <a href="admin.php" class="btn btn-primary">Click here to go to admin tools</a>
            </div>
            <br/>
            <?php
        }
        ?>
        <div>
            <form name="logout" method="POST">
                <input type="submit" name="logout" class="btn btn-danger" value="Logout"/>
            </form>
        </div>
        <?php
    } else { ?>
        <div>
            <form name="login" method="POST">
                <h2>Login</h2>
                <label for="log-username">Username</label>
                <input type="text" name="username" id="log-username"/>
                <label for="log-password">Password</label>
                <input type="password" name="password" id="log-password"/>
                <input type="submit" name="login" value="Login"/>
            </form>
        </div>
        <!--<div>
            <form name="register" method="POST">
                <h2>Register</h2>
                <label for="reg-username">Username</label>
                <input type="text" name="username" id="reg-username"/>
                <label for="reg-password">Password</label>
                <input type="password" name="password" id="reg-password"/>
                <input type="submit" name="register" value="Register"/>
            </form>
        </div>-->
    <?php } ?>
</div>

<?php
include 'footer.inc';
?>

</body>
</html>
