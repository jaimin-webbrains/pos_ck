<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    $customer_status = new CustomerStatus();
    $customer_status->name = trim($_POST['name']);

    try {
        $customer_status->save();
        Activity::log_action("CustomerStatus - saved : ".$customer_status->name);
        $_SESSION["message"] = "Successfully saved.";
        Functions::redirect_to("../customer_status.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        Functions::redirect_to("../customer_status.php");
    }
}

if (isset($_POST['update'])) {
    $customer_status = CustomerStatus::find_by_id($_POST['id']);
    $customer_status->name = trim($_POST['name']);
   
    try {
        $customer_status->save();
        Activity::log_action("CustomerStatus - updated : ".$customer_status->name);
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("../customer_status.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("../customer_status.php");
    }
}


if (isset($_POST['delete'])) {
    $customer_status = CustomerStatus::find_by_id($_POST["id"]);
    
    try {
        $customer_status->delete();
        Activity::log_action("CustomerStatus - deleted : ".$customer_status->name);
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("../customer_status.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("../customer_status.php");
    }
}
?>

