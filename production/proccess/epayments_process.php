<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    $role = new EpaymentOperator();
    $role->name = trim($_POST['name']);

    try {
        $role->save();
        Activity::log_action("Role - saved : ".$role->name);
        $_SESSION["message"] = "Successfully saved.";
        Functions::redirect_to("../epayments.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        Functions::redirect_to("../epayments.php");
    }
}

if (isset($_POST['update'])) {
    $role = EpaymentOperator::find_by_id($_POST['id']);
    $role->name = trim($_POST['name']);

    try {
        $role->save();
        Activity::log_action("Role - updated : ".$role->name);
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("../epayments.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("../epayments.php");
    }
}


if (isset($_POST['delete'])) {
    $role = EpaymentOperator::find_by_id($_POST["id"]);

    try {
        $role->delete();
        Activity::log_action("Role - deleted : ".$role->name);
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("../epayments.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("../epayments.php");
    }
}
?>
