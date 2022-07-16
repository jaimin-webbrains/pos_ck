<?php
require_once './../../util/initialize.php';
require_once './../../modal/StockTransfer.php';

if (isset($_POST['save'])) {
  $stock_transfer = new StockTransfer();

  if(empty($_POST['branch'])) { 
    $_SESSION["error"] = "Error..! Branch Should not be empty."; 
    Functions::redirect_to("../stock_transfer.php"); 
  } else{ 
    $stock_transfer->branch_id = trim($_POST['branch']); 
  }

  if(empty($_POST['code'])) { 
    $_SESSION["error"] = "Error..! Code Should not be empty."; 
    Functions::redirect_to("../stock_transfer.php"); 
  } else{ 
    $stock_transfer->p_code = trim($_POST['code']); 
  }

  $stock_transfer->reasons = trim($_POST['reasons']);
  $stock_transfer->stock_transfer_quantity = trim($_POST['stock_transfer_quantity']);
  $stock_transfer->datetime = trim($_POST['datetime']);
  
  try {
    $stock_transfer->save();
    Activity::log_action("StockTransfer - saved : ".$stock_transfer->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../stock_transfer.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../stock_transfer.php");
  }
}

if (isset($_POST['update'])) {
  $stock_transfer = StockTransfer::find_by_id($_POST['id']);
  $stock_transfer->p_code = trim($_POST['code']);
  $stock_transfer->branch_id = trim($_POST['branch']);
  $stock_transfer->reasons = trim($_POST['reasons']);
  $stock_transfer->stock_transfer_quantity = trim($_POST['stock_transfer_quantity']);
  $stock_transfer->datetime = trim($_POST['datetime']);
  try {
    $stock_transfer->save();
    Activity::log_action("StockTransfer - updated : ".$stock_transfer->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../stock_transfer.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../stock_transfer.php");
  }
}

if (isset($_POST['delete'])) {
  $stock_transfer = StockTransfer::find_by_id($_POST["id"]);
  try {
    $stock_transfer->delete();
    Activity::log_action("StockTransfer - deleted : ".$stock_transfer->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../stock_transfer.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../stock_transfer.php");
  }
}
?>
