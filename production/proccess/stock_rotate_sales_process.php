<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $stock_rotate_sales = new StockRotateSales();

  if(empty($_POST['branch'])) { 
    $_SESSION["error"] = "Error..! Branch Should not be empty."; 
    Functions::redirect_to("../stock_rotate_sales.php"); 
  } else{ 
    $stock_rotate_sales->branch_id = trim($_POST['branch']); 
  }

  if(empty($_POST['code'])) { 
    $_SESSION["error"] = "Error..! Code Should not be empty."; 
    Functions::redirect_to("../stock_rotate_sales.php"); 
  } else{ 
    $stock_rotate_sales->p_code = trim($_POST['code']); 
  }

  $stock_rotate_sales->reasons = trim($_POST['reasons']);
  $stock_rotate_sales->datetime = trim($_POST['datetime']);

  $stock_rotate_sales->quantity = trim($_POST['quantity']);
  
  try {
    $stock_rotate_sales->save();
    Activity::log_action("StockRotateSales - saved : ".$stock_rotate_sales->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../stock_rotate_sales.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../stock_rotate_sales.php");
  }
}

if (isset($_POST['update'])) {
  $stock_rotate_sales = StockRotateSales::find_by_id($_POST['id']);
  $stock_rotate_sales->p_code = trim($_POST['code']);
  $stock_rotate_sales->branch_id = trim($_POST['branch']);
  $stock_rotate_sales->reasons = trim($_POST['reasons']);
  $stock_rotate_sales->datetime = trim($_POST['datetime']);
  $stock_rotate_sales->quantity = trim($_POST['quantity']);
  try {
    $stock_rotate_sales->save();
    Activity::log_action("StockRotateSales - updated : ".$stock_rotate_sales->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../stock_rotate_sales.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../stock_rotate_sales.php");
  }
}

if (isset($_POST['delete'])) {
  $stock_rotate_sales = StockRotateSales::find_by_id($_POST["id"]);
  try {
    $stock_rotate_sales->delete();
    Activity::log_action("StockRotateSales - deleted : ".$stock_rotate_sales->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../stock_rotate_sales.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../stock_rotate_sales.php");
  }
}
?>
