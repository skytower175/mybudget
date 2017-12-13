<?php
require_once 'Data.inc';

/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 30/07/2016
 * Time: 3:08 PM
 */
class BudgetItem
{
    /**
     * ID of the item in the database.
     * @var int
     */
    public $id;

    /**
     *
     * @var string
     */
    public $idStr;

    /**
     * Reference number
     * e.g. 01 001
     * @var string
     */
    public $refNo;

    /**
     * Name of the item.
     * @var string
     */
    public $name;

    /**
     * Description for the item.
     * @var string
     */
    public $description;

    /**
     * @var double
     */
    public $price;

    /**
     * Name of the cluster
     * @var string
     */
    public $cluster;

    /**
     * ID of the category it belongs to.
     * @var int
     */
    public $categoryId;

    /**
     * Name of the category
     * @var string
     */
    public $categoryName;

    /**
     * Unit of measurement.
     * @var string
     */
    public $unitMeasure;

    /**
     * @var bool
     */
    public $quoteRequired;

    /**
     * @var bool
     */
    public $sponsored;

}

class Category
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $colour;
}

/*
 * Contains all general-purpose functions for getting/setting BudgetItems, etc.
 */

class BudgetItemLoader
{

    /**
     * Function for getting all items out of the database and putting them in the BudgetItem class.
     * @return BudgetItem[]
     */
    public static function GetBudgetItems()
    {
        $items = array();
        $queryResults = RunQuery('SELECT item.id, item.id_str, item.id_disp, item.name, item.descr, 
                item.unit, item.quote, item.price, item.cluster, item.category_id, item.sponsored, category.name AS category_name 
                FROM item 
                LEFT JOIN category ON item.category_id = category.id', array());
        foreach ($queryResults as $row) {
            $item = new BudgetItem();
            $item->id = $row['id'];
            $item->idStr = $row['id_str'];
            $item->refNo = $row['id_disp'];
            $item->name = $row['name'];
            $item->description = $row['descr'];
            $item->unitMeasure = $row['unit'];
            $item->quoteRequired = $row['quote'];
            $item->price = $row['price'];
            $item->cluster = $row['cluster'];
            $item->categoryId = $row['category_id'];
            $item->categoryName = $row['category_name'];
            $item->sponsored = $row['sponsored'];
            array_push($items, $item);
        }
        return $items;
    }
    
    
    /**
     * Function for getting individual item by its idStr
     * @return BudgetItem
     */
    public static function GetSingleItem($idStr)
    {
        $queryResults = RunQuery('SELECT item.id, item.id_str, item.id_disp, item.name, item.descr, 
            item.unit, item.quote, item.price, item.cluster, item.category_id, item.sponsored, category.name AS category_name 
            FROM item 
            LEFT JOIN category ON item.category_id = category.id
            WHERE item.id_str like ?', array($idStr));
        if (count($queryResults) == 1) {
            $row = $queryResults[0];
            $item = new BudgetItem();
            $item->id = $row['id'];
            $item->idStr = $row['id_str'];
            $item->refNo = $row['id_disp'];
            $item->name = $row['name'];
            $item->description = $row['descr'];
            $item->unitMeasure = $row['unit'];
            $item->quoteRequired = $row['quote'];
            $item->price = $row['price'];
            $item->cluster = $row['cluster'];
            $item->categoryId = $row['category_id'];
            $item->categoryName = $row['category_name'];
            $item->sponsored = $row['sponsored'];
            return $item;
        }
        else
            return null;
    }

    /**
     * @return BudgetItem[]
     */
    public static function GetItemsByCategory($categoryId)
    {
        $items = array();
        $queryResults = RunQuery('SELECT item.id, item.id_str, item.id_disp, item.name, item.descr,
                item.unit, item.quote, item.price, item.cluster, item.category_id, item.sponsored, category.name AS category_name
                FROM item
                LEFT JOIN category ON item.category_id = category.id
                WHERE item.category_id = ?', array($categoryId));
        foreach ($queryResults as $row) {
            $item = new BudgetItem();
            $item->id = $row['id'];
            $item->idStr = $row['id_str'];
            $item->refNo = $row['id_disp'];
            $item->name = $row['name'];
            $item->description = $row['descr'];
            $item->unitMeasure = $row['unit'];
            $item->quoteRequired = $row['quote'];
            $item->price = $row['price'];
            $item->cluster = $row['cluster'];
            $item->categoryId = $row['category_id'];
            $item->categoryName = $row['category_name'];
            $item->sponsored = $row['sponsored'];
            array_push($items, $item);
        }
        return $items;
    }

    /**
     * @return Category[]
     */
    public static function GetCategoriesFromDB()
    {
        //id, name, picture, colour
        $categories = array();
        $queryResults = RunQuery('SELECT id, name, image, colour FROM category', array());
        foreach ($queryResults as $row) {
            $cat = new Category();
            $cat->id = $row['id'];
            $cat->name = $row['name'];
            $cat->image = $row['image'];
            $cat->colour = $row['colour'];
            array_push($categories, $cat);
        }
        return $categories;
    }

    /**
     * @param $items BudgetItem[]
     * @return Category[]
     */
    public static function GetCategoriesFromItems($items)
    {
        $categories = array();
        foreach ($items as $item) {
//            $category = array($item->categoryId, $item->categoryName);
            $cat = new Category();
            $cat->id = $item->categoryId;
            $cat->name = $item->categoryName;
            if (in_array($cat, $categories) == false)
                array_push($categories, $cat);
        }
        usort($categories, function ($a, $b) {
            return $a->id - $b->id;
        });
        return $categories;
    }

    /**
     * @param $items BudgetItem[]
     */
    public static function UploadBudgetItems($items)
    {
        foreach ($items as $item) {
            RunQuery('INSERT INTO item(id_str, id_disp, name, descr, unit, quote, price, cluster, category_id)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($item->idStr, $item->refNo, $item->name, $item->description, $item->unitMeasure, $item->quoteRequired, $item->price, $item->cluster, $item->categoryId));
        }
    }

    public static function UploadNewBudgetItems($items)
    {
        RunQuery('truncate table item', array());
        self::UploadBudgetItems($items);
    }

    public static function UpdateBudgetItem($item)
    {

    }

}
