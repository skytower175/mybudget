<?php

/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 17/09/2016
 * Time: 12:56 PM
 */

require_once 'Data.inc';

class User
{
    public $id;
    public $username;
    public $admin;
}

class UserLoader
{
    public static function GetUserById($userid)
    {
        $queryResults = RunQuery('SELECT * FROM account WHERE id = ?', array($userid));
        if (sizeof($queryResults) == 1) {
            $row = $queryResults[0];
            $user = new User();
            $user->id = $row['id'];
            $user->username = $row['username'];
            $user->admin = $row['admin'];
            return $user;
        } else {
            return null;
        }
    }

    /**
     * @param $username string
     * @param $password string
     * @param $admin bool
     */
    public static function CreateUser($username, $password, $admin)
    {
        $result = new Result();
        $qry = 'INSERT INTO account (username, password, salt, admin, active) VALUES (?, SHA2(CONCAT(?, ?), 0), ?, ?, ?)';
        $salt = "asdf";
        $queryResults = RunQuery($qry, array($username, $password, $salt, $salt, $admin, 1));
        return $result;
    }

    /**
     * @param $username string
     * @param $password string
     * @return Result
     */
    public static function MatchCredentials($username, $password)
    {
        $result = new Result();
        $qry = 'SELECT * FROM account WHERE username = ? AND password = SHA2(concat(?, salt), 0)';
        $queryResults = RunQuery($qry, array($username, $password));
        if (sizeof($queryResults) == 1) {
            $result->isError = false;
            $result->message = "Credentials match";
            $result->returnKey = $queryResults[0]['id'];
        } else {
            $result->isError = true;
            $result->message = "Credentials do not match";
        }
        return $result;
    }
}

?>