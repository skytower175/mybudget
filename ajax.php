<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 27/09/2016
 * Time: 7:53 PM
 */
require_once 'Includes/PageData.inc';
$page = new PageData();
$page->title = "AJAX";
$page->adminOnly = false;
require_once 'Includes/SessionCheck.inc';

require_once 'Includes/Functions.inc';
require_once 'Includes/BudgetItemLoader.inc';

if (isset($_REQUEST['get'])) {
    switch ($_REQUEST['get']) {
        case 'cat': {
            $arr = BudgetItemLoader::GetCategoriesFromDB();
            echo json_encode($arr);
            break;
        }
        case 'items':
            $arr = BudgetItemLoader::GetBudgetItems();
            echo json_encode($arr);
            break;
        case 'wizard':
            require_once('Includes/WizardLoader.inc');
            $arr = WizardLoader::GetWizardItems();
            echo json_encode($arr);
            break;
        default:
            break;
    }
    exit();
} elseif (isset($_REQUEST['update']) && $currUser->admin) {
    switch($_REQUEST['update']) {
    case 'item':
        $id = $_REQUEST['id'];
        $dt = $_POST['data'];
        $dti = json_decode($_POST['data']);
        WriteLog("update", $dt);
        RunQuery('UPDATE item SET cluster=? WHERE id_str LIKE ?', array($dti->cluster, $id));
        RunQuery('UPDATE item SET name=? WHERE id_str LIKE ?', array($dti->name, $id));
        RunQuery('UPDATE item SET price=? WHERE id_str LIKE ?', array(floatval($dti->price), $id));
        RunQuery('UPDATE item SET descr=? WHERE id_str LIKE ?', array($dti->description, $id));
        RunQuery('UPDATE item SET quote=? WHERE id_str LIKE ?', array((int)$dti->quote, $id));
        RunQuery('UPDATE item SET category_id=? WHERE id_str LIKE ?', array((int)$dti->categoryId, $id));
        RunQuery('UPDATE item SET sponsored=? WHERE id_str LIKE ?', array((int)$dti->sponsored, $id));
        WriteLog("update finished", json_encode(BudgetItemLoader::GetSingleItem($id)));
        //RunQuery('UPDATE item SET category=? WHERE id_str LIKE ?', array($dti->categoryId, $id)); //buggy line
        break;
    case 'wizard':
        $data = $_POST['wizardItems'];
        echo $data;
        $dti = json_decode($data);
        WriteLog("update wizard", $data);
        RunQuery('TRUNCATE TABLE wizard_question', array());
        RunQuery('TRUNCATE TABLE wizard_link', array());
        $i = 1;
        foreach ($dti as $row){
            RunQuery('INSERT INTO wizard_question(id, step_num, question) values(?, ?, ?)', array($row->id, $i, $row->question));
            //WriteLog("uw", $row->id);
            ////WriteLog("abc", $dit->itemIds);
            //WriteLog("dti", json_encode($dti));
            //WriteLog("abc", json_encode($dti->itemIds));
            foreach($row->itemIds as $items){
                //WriteLog("asdf", $items);
                RunQuery('INSERT INTO wizard_link(wizard_question, item_id_str) values(?, ?)', array($row->id, $items));
            }
            $i++;
        }
        //RunQuery('INSERT INTO wizard_question(step_num, question) values(5, ?)', array('test'));
        //RunQuery('UPDATE wizard_question ');
        //RunQuery('UPDATE wizard_link ');
        break;
    default:
        break;
    }
    exit();
} elseif (isset($_REQUEST['test']) && $currUser->admin) {
    $id = $_REQUEST['test'];
    $dt = $_POST['data'];
    echo $dt;
    $dti = json_decode($_POST['data']);
    WriteLog("update", $dt);
    RunQuery('UPDATE item SET name=? WHERE id_str LIKE ?', array($dti->name, $id));
    //RunQuery('UPDATE item SET price=? WHERE id_str LIKE ?', array($dti->price, $id));
    RunQuery('UPDATE item SET descr=? WHERE id_str LIKE ?', array($dti->description, $id));
    WriteLog("update done", "");
    //RunQuery('UPDATE item SET category=? WHERE id_str LIKE ?', array($dti->categoryId, $id)); //buggy line
    //echo $dti->price;
    //echo json_decode($_POST['data']);
    exit();
} elseif (isset($_REQUEST['log'])) {
    $log = $_REQUEST['log'];
    WriteLog("log", $log);
    exit();
}
?>
