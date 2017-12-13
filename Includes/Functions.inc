<?php

require_once 'Data.inc';

/**
 * This file contains all general-purpose functions.
 */

class Log {
    public $id;
    public $date;
    public $type;
    public $title;
    public $descr;
}

function GetAllLogs(){
    $items = array();
    $queryResults = RunQuery('select * from log order by id desc', array());
    foreach($queryResults as $row) {
        $log = new Log();
        $log->id = $row['id'];
        $log->date = $row['log_date'];
        $log->type = $row['type'];
        $log->title = $row['title'];
        $log->descr = $row['descr'];
        array_push($items, $log);
    }
    return $items;
}


/**
 * @param $title
 * @param $description
 */
function WriteLog($title, $description)
{
    $qryresults = RunQuery ( "INSERT INTO log (log_date, type, title, descr)
        VALUES(now(), 'general', ?, ?);", array (
            $title,
            $description 
        ) );
}

/**
 * @param $title
 * @param $description
 */
function WriteError($title, $description)
{
    $qryresults = RunQuery ( "INSERT INTO log (log_date, type, title, descr)
        VALUES(now(), 'error', ?, ?);", array (
            $title,
            substr($description, 0, 99)
        ) );
}

