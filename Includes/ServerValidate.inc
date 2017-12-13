<?php
require_once 'Data.inc';
require_once 'User.inc';

/**
 * @param $string string
 * @return string
 */
function FixInput($string)
{
    return $string;
}

function CheckInputFields($username, $password)
{
    $result = new Result();
    if ($username == null || $username == "" || sizeof($username) <= 0) {
        $result->isError = true;
        $result->message = "Username can not be blank or empty.";
        return $result;
    }

    if ($password == null || $password == "" || sizeof($password) <= 0) {
        $result->isError = true;
        $result->message = "Password can not be blank or empty.";
        return $result;
    }
    return $result;
}

/**
 * @param $username string
 * @param $password string
 * @return Result
 */
function Register($username, $password)
{
    $result = new Result();
    $inputCheck = CheckInputFields($username, $password);
    if ($inputCheck->isError)
        return $inputCheck;
    $isAdmin = 0;
    UserLoader::CreateUser($username, $password, $isAdmin);
    return $result;
}

/**
 * @param $username string
 * @param $password string
 * @return Result
 */
function Login($username, $password)
{
    $result = new Result();
    $inputCheck = CheckInputFields($username, $password);
    if ($inputCheck->isError)
        return $inputCheck;
    $credMatch = UserLoader::MatchCredentials($username, $password);
    if ($credMatch->isError == false) {
        //TODO: log in and set the session here
        $_SESSION['userid'] = $credMatch->returnKey;
        $result->message = "You are now logged in.";
    } else {
        $result->isError = true;
        $result->message = "Your username or password did not match.";
    }
    return $result;
}