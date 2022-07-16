<?php

require_once './../../util/initialize.php';
require_once __DIR__ . "/../../util/functions.php";
require_once __DIR__ . "/../../util/session.php";


if (isset($_POST["submit"])) {
    global $session;
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $errors = Session::attempt_login($username, $password);
        if (empty($errors)) {
            Functions::redirect_to("./../index.php");
        } else {
            $_SESSION["error"] = join("<br/>", $errors);
            Functions::redirect_to("./../login.php");
        }
    } else {
        $_SESSION["error"] = "Username or password empty !";
        Functions::redirect_to("./../login.php");
    }
} else {
    $_SESSION["error"] = "Submission not ok !";
    Functions::redirect_to("./../login.php");
}

