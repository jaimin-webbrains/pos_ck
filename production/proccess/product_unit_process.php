<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $product = new ProductUnit();

  if(empty($_POST['code'])) { 
    $_SESSION["error"] = "Error..! Code Should not be empty."; 
    Functions::redirect_to("../product_unit.php"); 
  } else{ 
    $product->p_code = trim($_POST['code']); 
  }

  $product->p_volume = trim($_POST['volume']);
  $product->p_unit = trim($_POST['unit']);
  
  try {
    $product->save();
    Activity::log_action("ProductUnit - saved : ".$product->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../product_unit.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../product_unit.php");
  }
}

if (isset($_POST['update'])) {
  $product = ProductUnit::find_by_id($_POST['id']);
  $product->p_code = trim($_POST['code']);
  $product->p_volume = trim($_POST['volume']);
  $product->p_unit = trim($_POST['unit']);
  try {
    $product->save();
    Activity::log_action("Product - updated : ".$product->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../product_unit.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../product_unit.php");
  }
}

if (isset($_POST['delete'])) {
  $product = ProductUnit::find_by_id($_POST["id"]);
  try {
    $product->delete();
    Activity::log_action("ProductUnit - deleted : ".$product->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../product_unit.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../product_unit.php");
  }
}
?>
