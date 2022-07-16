<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    // echo '<pre>';
    // print_r($_POST['product']);
    // die;
  foreach($_POST['product'] as $row_product){
    $stock_product_usage = new StockProductUsage();

    if(empty($row_product['branch'])) { 
      $_SESSION["error"] = "Error..! Branch Should not be empty."; 
      Functions::redirect_to("../stock_product_usage.php"); 
    } else{ 
      $stock_product_usage->branch_id = trim($row_product['branch']); 
    }

    if(empty($row_product['code'])) { 
      $_SESSION["error"] = "Error..! Code Should not be empty."; 
      Functions::redirect_to("../stock_product_usage.php"); 
    } else{ 
      $stock_product_usage->p_code = trim($row_product['code']); 
    }

    $stock_product_usage->barcode = trim($row_product['barcode']);
    $stock_product_usage->quantity = trim($row_product['quantity']);
    $stock_product_usage->datetime = trim($row_product['datetime']);
    $stock_product_usage->save();
  }
  
  try {
    
    Activity::log_action("StockProductUsage - saved : ".$stock_product_usage->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../stock_product_usage.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../stock_product_usage.php");
  }
}

if (isset($_POST['update'])) {
  //  echo '<pre>';
  //   print_r($_POST);
  //   die;
  foreach($_POST['product'] as $row_product){
    $stock_product_usage = StockProductUsage::find_by_id($_POST['id']);
    $stock_product_usage->p_code = trim($row_product['code']);
    $stock_product_usage->branch_id = trim($row_product['branch']);
    $stock_product_usage->barcode = trim($row_product['barcode']);
    $stock_product_usage->quantity = trim($row_product['quantity']);
    $stock_product_usage->datetime = trim($row_product['datetime']);
    $stock_product_usage->save();
  }
  try {
    
    Activity::log_action("StockProductUsage - updated : ".$stock_product_usage->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../stock_product_usage.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../stock_product_usage.php");
  }
}

if (isset($_POST['delete'])) {
  $stock_product_usage = StockProductUsage::find_by_id($_POST["id"]);
  try {
    $stock_product_usage->delete();
    Activity::log_action("StockProductUsage - deleted : ".$stock_product_usage->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../stock_product_usage.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../stock_product_usage.php");
  }
}
?>
