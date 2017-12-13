<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 25/09/2016
 * Time: 12:57 PM
 */

require_once 'BudgetItemLoader.inc';
require_once 'Plugins/Encoding.php';
use \ForceUTF8\Encoding;

function FixData($text){
    $output = Encoding::toUTF8($text);
    return $output;
}

function GetItemsFromCSV()
{
    $items = array();
    if (is_uploaded_file($_FILES ['csvfile'] ['tmp_name'])) {
        $handle = fopen($_FILES ['csvfile'] ['tmp_name'], "r");
        $titles = fgetcsv($handle, 1000, ",");
        if (count($titles) == 9) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $item = new BudgetItem ();
                $item->cluster = FixData($data [0]);
                $item->name = FixData($data [1]);
                $item->idStr = str_replace(" ", "_", FixData($data [2]));
                $item->refNo = FixData($data [2]);
                $item->description = FixData($data [3]);
                $item->unitMeasure = FixData($data [4]);
                $item->quoteRequired = FixData($data [5]) == 'Y' ? 1 : 0;
                $item->price = floatval(str_replace(array("$", ","), "", FixData($data [6])));
                $item->categoryName = FixData($data [7]);
                $item->categoryId = FixData($data [8]);
                array_push($items, $item);
            }
        } elseif (count($titles) == 10) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $item = new BudgetItem ();
                array_push($items, $item);
            }
        }
        fclose($handle);
    }
    return $items;
}