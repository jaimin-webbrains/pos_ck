<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $service_category = new ServiceCategory();
  $service_category->name = trim($_POST['name']);

  $object = ServiceCategory::find_by_product_name($_POST['name']);

  if( count($object) == 0 ){
    try {
      $service_category->save();
      Activity::log_action("ServiceCategory - saved : ".$service_category->name);
      $_SESSION["message"] = "Successfully saved.";
      Functions::redirect_to("../service_category.php");
    } catch (Exception $exc) {
      $_SESSION["error"] = "Error..! Failed to save.";
      Functions::redirect_to("../service_category.php");
    }
  }else{
    $_SESSION["error"] = "Error..! Alredy Exists.";
    Functions::redirect_to("../service_category.php");
  }

}

if (isset($_POST['update'])) {
  $service_category = ServiceCategory::find_by_id($_POST['id']);
  $service_category->name = trim($_POST['name']);

  try {
    $service_category->save();
    Activity::log_action("ServiceCategory - updated : ".$service_category->name);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../service_category.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../service_category.php");
  }
}


if (isset($_POST['delete'])) {
  $service_category = ServiceCategory::find_by_id($_POST["id"]);

  try {
    $service_category->delete();
    Activity::log_action("ServiceCategory - deleted : ".$service_category->name);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../service_category.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../service_category.php");
  }
}
?>
