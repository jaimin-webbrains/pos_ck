<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    $branch = new Branch();
    $branch->name = trim($_POST['name']);
    $branch->code = trim($_POST['code']);
     $branch->cog = trim($_POST['cog']);

    try {
        $branch->save();
        Activity::log_action("Branch - saved : ");
        $_SESSION["message"] = "Successfully saved.";
        Functions::redirect_to("../branch.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        Functions::redirect_to("../branch.php");
    }
}

if (isset($_POST['update'])) {
    $branch = Branch::find_by_id($_POST['id']);
    $branch->name = trim($_POST['name']);
     $branch->code = trim($_POST['code']);
     $branch->cog = trim($_POST['cog']);


    try {
        $branch->save();
        Activity::log_action("Branch - updated : ");
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("../branch.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("../branch.php");
    }
}


if (isset($_POST['delete'])) {

    $branch = Branch::find_by_id($_POST["id"]);

    print_r($branch);

    try {
        $branch->delete();
        Activity::log_action("Branch - deleted : ");
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("../branch.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("../branch.php");
    }
}
?>
