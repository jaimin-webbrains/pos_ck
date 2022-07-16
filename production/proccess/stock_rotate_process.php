<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $stock_rotate = new StockRotate();

  if(empty($_POST['branch'])) { 
    $_SESSION["error"] = "Error..! Branch Should not be empty."; 
    Functions::redirect_to("../stock_rotate.php"); 
  } else{ 
    $stock_rotate->branch_id = trim($_POST['branch']); 
  }

  if(empty($_POST['code'])) { 
    $_SESSION["error"] = "Error..! Code Should not be empty."; 
    Functions::redirect_to("../stock_rotate.php"); 
  } else{ 
    $stock_rotate->p_code = trim($_POST['code']); 
  }

  $stock_rotate->reasons = trim($_POST['reasons']);
  $stock_rotate->datetime = trim($_POST['datetime']);
  
  try {
    $stock_rotate->save();
    Activity::log_action("StockRotate - saved : ".$stock_rotate->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../stock_rotate.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../stock_rotate.php");
  }
}

if (isset($_POST['update'])) {
  $stock_rotate = StockRotate::find_by_id($_POST['id']);
  $stock_rotate->p_code = trim($_POST['code']);
  $stock_rotate->branch_id = trim($_POST['branch']);
  $stock_rotate->reasons = trim($_POST['reasons']);
  $stock_rotate->datetime = trim($_POST['datetime']);
  try {
    $stock_rotate->save();
    Activity::log_action("StockRotate - updated : ".$stock_rotate->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../stock_rotate.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../stock_rotate.php");
  }
}

if (isset($_POST['delete'])) {
  $stock_rotate = StockRotate::find_by_id($_POST["id"]);
  try {
    $stock_rotate->delete();
    Activity::log_action("StockRotate - deleted : ".$stock_rotate->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../stock_rotate.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../stock_rotate.php");
  }
}
?>
