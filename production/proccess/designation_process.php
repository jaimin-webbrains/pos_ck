<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    $designation = new Designation();
    $designation->name = trim($_POST['name']);

    try {
        $designation->save();
        Activity::log_action("Designation - saved:".$designation->name);
        $_SESSION["message"] = "Successfully saved.";
        Functions::redirect_to("./../designation.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        Functions::redirect_to("./../designation.php");
    }
}

if (isset($_POST['update'])) {
    $designation = Designation::find_by_id($_POST['id']);
    $designation->name = trim($_POST['name']);
   
    try {
        $designation->save();
        Activity::log_action("Designation - updated:".$designation->name);
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("./../designation.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("./../designation.php");
    }
}


if (isset($_POST['delete'])) {
    $designation = Designation::find_by_id($_POST["id"]);
    
    try {
        $designation->delete();
        Activity::log_action("Designation - deleted:".$designation->name);
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("./../designation.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("./../designation.php");
    }
}
?>


