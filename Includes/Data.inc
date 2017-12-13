<?php
require_once 'Config.inc';
try {
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $dbusername = getenv('DB_USER');
    $dbpassword = getenv('DB_PASS');
    $pdo = new PDO ("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
//    echo 'Database connection failed.';
} catch (Exception $e) {
//    echo "Another exception has occurred.";
}

function RunQuery($qry, $parms)
{
    global $pdo;
    if (!isset ($pdo)) {
        throw new PDOException ("No data connection.");
        return null;
    } else {
        $sth = $pdo->prepare($qry, array(
            PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY
        ));
        $red = null;
        $sth->execute($parms);
        try {
            $red = $sth->fetchAll();
        } catch (PDOException $e) {
        }
        return $red;
    }
}

class Result
{
    public $isError = false;
    public $message = "";
    public $returnKey = -1;
}

?>
