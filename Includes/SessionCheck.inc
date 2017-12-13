<?php
session_start();
require_once 'User.inc';
$userid = isset ( $_SESSION ['userid'] ) ? $_SESSION ['userid'] : null;
$currUser = $userid != null ? UserLoader::GetUserById($userid) : null;
$signed_in = isset($currUser);
if ($page->adminOnly && !($signed_in && $currUser->admin == true)){
    http_response_code(403); //403 = Not authorised
    exit();
}
?>