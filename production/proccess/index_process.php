<?php
require_once './../../util/initialize.php';

if(isset($_GET['inv_delete'])){

  $inv_del = Invoice::find_by_id($_GET['inv_delete']);

  try {
    $inv_del->delete();
    Activity::log_action("Pending Invoice Deleted: ");
    $_SESSION["message"] = "Successfully Deleted.";
    Functions::redirect_to("../index.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    Functions::redirect_to("../index.php");
  }
}
