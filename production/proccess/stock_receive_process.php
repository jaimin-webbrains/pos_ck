<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $stock_receive = new StockReceive();

  if(empty($_POST['code'])) { 
    $_SESSION["error"] = "Error..! Code Should not be empty."; 
    Functions::redirect_to("../stock_receive.php"); 
  } else{ 
    $stock_receive->p_code = trim($_POST['code']); 
  }

  $stock_receive->barcode = trim($_POST['barcode']);
  $stock_receive->quantity = trim($_POST['quantity']);
  $stock_receive->datetime = trim($_POST['datetime']);
  
  try {
    $stock_receive->save();
    Activity::log_action("StockReceive - saved : ".$stock_receive->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../stock_receive.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../stock_receive.php");
  }
}

if (isset($_POST['update'])) {
  $stock_receive = StockReceive::find_by_id($_POST['id']);
  $stock_receive->p_code = trim($_POST['code']);
  $stock_receive->barcode = trim($_POST['barcode']);
  $stock_receive->quantity = trim($_POST['quantity']);
  $stock_receive->datetime = trim($_POST['datetime']);
  try {
    $stock_receive->save();
    Activity::log_action("StockReceive - updated : ".$stock_receive->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../stock_receive.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../stock_receive.php");
  }
}

if (isset($_POST['delete'])) {
  $stock_receive = StockReceive::find_by_id($_POST["id"]);
  try {
    $stock_receive->delete();
    Activity::log_action("StockReceive - deleted : ".$stock_receive->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../stock_receive.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../stock_receive.php");
  }
}
?>
