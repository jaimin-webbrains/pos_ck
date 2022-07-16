<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $stock_write_off = new StockWriteOff();

  if(empty($_POST['branch'])) { 
    $_SESSION["error"] = "Error..! Branch Should not be empty."; 
    Functions::redirect_to("../stock_write_off.php"); 
  } else{ 
    $stock_write_off->branch_id = trim($_POST['branch']); 
  }

  if(empty($_POST['code'])) { 
    $_SESSION["error"] = "Error..! Code Should not be empty."; 
    Functions::redirect_to("../stock_write_off.php"); 
  } else{ 
    $stock_write_off->p_code = trim($_POST['code']); 
  }

  $stock_write_off->reasons = trim($_POST['reasons']);
  $stock_write_off->write_off_quantity = trim($_POST['writeoff']);
  $stock_write_off->datetime = trim($_POST['datetime']);
  
  try {
    $stock_write_off->save();
    Activity::log_action("StockWriteOff - saved : ".$stock_write_off->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../stock_write_off.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../stock_write_off.php");
  }
}

if (isset($_POST['update'])) {
  $stock_write_off = StockWriteOff::find_by_id($_POST['id']);
  $stock_write_off->p_code = trim($_POST['code']);
  $stock_write_off->branch_id = trim($_POST['branch']);
  $stock_write_off->reasons = trim($_POST['reasons']);
  $stock_write_off->write_off_quantity = trim($_POST['writeoff']);
  $stock_write_off->datetime = trim($_POST['datetime']);
  try {
    $stock_write_off->save();
    Activity::log_action("StockWriteOff - updated : ".$stock_write_off->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../stock_write_off.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../stock_write_off.php");
  }
}

if (isset($_POST['delete'])) {
  $stock_write_off = StockWriteOff::find_by_id($_POST["id"]);
  try {
    $stock_write_off->delete();
    Activity::log_action("StockWriteOff - deleted : ".$stock_write_off->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../stock_write_off.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../stock_write_off.php");
  }
}
?>
