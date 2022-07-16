<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $branch = new BranchWorkingTime();
  $branch->branch_id = trim($_POST['branch_id']);
  $branch->start_time = trim($_POST['start_time']);
  $branch->end_time = trim($_POST['end_time']);

  try {
    $branch->save();
    Activity::log_action("Branch Woking Time - saved : ");
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../branch_working_time.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    Functions::redirect_to("../branch_working_time.php");
  }
}

if (isset($_POST['update'])) {
  $branch = BranchWorkingTime::find_by_id($_POST['id']);
  $branch->branch_id = trim($_POST['branch_id']);
  $branch->start_time = trim($_POST['start_time']);
  $branch->end_time = trim($_POST['end_time']);


  try {
    $branch->save();
    Activity::log_action("Branch Woking Time - updated : ");
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../branch_working_time.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../branch_working_time.php");
  }
}


if (isset($_POST['delete'])) {

  $branch = BranchWorkingTime::find_by_id($_POST["id"]);

//   print_r($branch);

  try {
    $branch->delete();
    Activity::log_action("Branch Woking Time - deleted : ");
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../branch_working_time.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../branch_working_time.php");
  }
}
?>
