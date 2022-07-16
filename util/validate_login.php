<?php

//date_default_timezone_set('Asia/Colombo');
//require_once __DIR__ . '/session.php';
//require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/initialize.php';

global $session;
if ($session->check_login() && User::find_by_id($_SESSION["user"]["id"])) {
    $last_action = $_SESSION["user"]["time"];
    $now = date('Y-m-d H:i:s');
    $time_diff = Functions::dateTimeDifference($last_action,$now);
    if (($time_diff / 60) > 30) {
        Session::logout_and_redirect("Session expired..! Please Login again...");
    } else {
        $_SESSION["user"]["time"] = $now;
        $_SESSION["user"]["privileges"] = Session::get_privileges_by_user_id($_SESSION["user"]["id"]);
    }
} else {
    Session::logout_and_redirect();
    
}