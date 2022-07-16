<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $product_category = new ProductCategory();
  $product_category->name = trim($_POST['name']);
  $product_category->commission = trim($_POST['commission']);

  $object = ProductCategory::find_by_product_name($_POST['name']);

  if( count($object) == 0 ){
    try {
      $product_category->save();
      Activity::log_action("ProductCategory - saved : ".$product_category->name);
      $_SESSION["message"] = "Successfully saved.";
      Functions::redirect_to("../product_category.php");
    } catch (Exception $exc) {
      $_SESSION["error"] = "Error..! Failed to save.";
      Functions::redirect_to("../product_category.php");
    }
  }else{
    $_SESSION["error"] = "Error..! Alredy Exists.";
    Functions::redirect_to("../product_category.php");
  }
}

if (isset($_POST['update'])) {
  $product_category = ProductCategory::find_by_id($_POST['id']);
  $product_category->name = trim($_POST['name']);
   $product_category->commission = trim($_POST['commission']);

  try {
    $product_category->save();
    Activity::log_action("ProductCategory - updated : ".$product_category->name);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../product_category.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../product_category.php");
  }
}


if (isset($_POST['delete'])) {

  $product_category = ProductCategory::find_by_id($_POST["id"]);

  print_r($product_category);

  try {
    $product_category->delete();
    Activity::log_action("PackageCategory - deleted : ".$product_category->name);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../product_category.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../product_category.php");
  }
}
?>
