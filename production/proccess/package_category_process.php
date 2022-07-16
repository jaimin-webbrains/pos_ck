<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $package_category = new PackageCategory();
  $package_category->name = trim($_POST['name']);

  $object = PackageCategory::find_by_product_name($_POST['name']);

  if( count($object) == 0 ){
    try {
      $package_category->save();
      Activity::log_action("PackageCategory - saved : ".$package_category->name);
      $_SESSION["message"] = "Successfully saved.";
      Functions::redirect_to("../package_category.php");
    } catch (Exception $exc) {
      $_SESSION["error"] = "Error..! Failed to save.";
      Functions::redirect_to("../package_category.php");
    }
  }else{
    $_SESSION["error"] = "Error..! Alredy Exists.";
    Functions::redirect_to("../package_category.php");
  }
}

if (isset($_POST['update'])) {
  $package_category = PackageCategory::find_by_id($_POST['id']);
  $package_category->name = trim($_POST['name']);

  try {
    $package_category->save();
    Activity::log_action("PackageCategory - updated : ".$package_category->name);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../package_category.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../package_category.php");
  }
}


if (isset($_POST['delete'])) {

  $package_category = PackageCategory::find_by_id($_POST["id"]);

  print_r($package_category);

  try {
    $package_category->delete();
    Activity::log_action("PackageCategory - deleted : ".$package_category->name);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../package_category.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../package_category.php");
  }
}
?>
