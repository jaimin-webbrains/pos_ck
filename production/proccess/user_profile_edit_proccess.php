<?php

require_once './../../util/initialize.php';


if (isset($_POST['save'])) {
    $user = User::find_by_id($_POST['id']);
    $user->username = trim($_POST['username']);
    $user->password = Functions::encrypt_string(trim($_POST['password']));

    try {
        $user->save();
        Activity::log_action("User - password changed : ".$user->name);
        $_SESSION["message"] = "Successfull.";
        Functions::redirect_to("./../user_profile_edit.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error saving user details . Please try again";
        Functions::redirect_to("./../user_profile_edit.php");
    }
}


if (isset($_POST["encrypt"])) {
    $value = Functions::encrypt_string($_POST["string"]);
    echo json_encode($value);
}

if (isset($_POST["findByUsername"])) {
    $result=FALSE;
    if(User::find_by_username($_POST["string"])){
        $result=true;
    }
    
    echo json_encode($result);
}