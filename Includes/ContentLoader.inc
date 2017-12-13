<?php
require_once 'Data.inc';

class Content {
    public $id;
    public $name;
    public $description;
    public $content;
}

function GetContent($id){
    $queryResults = RunQuery('select content from content where id=?', array($id));
    if (count($queryResults) == 1){
        return $queryResults[0][0];
    }
    else {
        return "";
    }
}

function GetContentClass($id){
    $queryResults = RunQuery('select * from content where id=?', array($id));
    if (count($queryResults) == 1){
        $row = $queryResults[0];
        $content = new Content();
        $content->id = $row['id'];
        $content->name = $row['name'];
        $content->description = $row['description'];
        $content->content = $row['content'];
        return $content;
    }
    else {
        return null;
    }
}

function UpdateContent($id, $content){
    $queryResults = RunQuery('update content set content=? where id=?', array($content, $id));
}

function GetAllContent(){
    $queryResults = RunQuery('select * from content', array());
    return $queryResults;
}
