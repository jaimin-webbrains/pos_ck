<?php
require_once './../../util/initialize.php';
if (isset($_POST['save'])) {
  $product = new ProductUsageServices();

  if(empty($_POST['code']))
  { $_SESSION["error"] = "Error..! Code Should not be empty."; Functions::redirect_to("../product_services.php"); }
  else{
    $checkP_Code = Service::find_by_code($_POST["code"]);
    if(empty($checkP_Code))
    {
      $_SESSION["error"] = "Error..! Service code does not exist in the database. Please Try again!";
      Functions::redirect_to("../product_services.php");
    }
    else {
      $product->p_code = trim($_POST['code']);
    }
  }

  $usage_code = implode(', ', $_POST['p_u_code']);
  $x = (explode(",", $usage_code));
  $y = (explode(",", $_POST['volume']));
  if(count($x) > 5)
  {
    $_SESSION["error"] = "Error..! Product Used code and Volume must not be more than 5 entries!";
    Functions::redirect_to("../product_service.php");
  }
  else{
    if(count($x) != count($y))
    {
      $_SESSION["error"] = "Error..! Product Used code and Volume must Match!";
      Functions::redirect_to("../product_service.php");
    }
  }
  $product->p_use_code = $usage_code;
  $product->volume = trim($_POST['volume']);
  try {
    $product->save();
    Activity::log_action("ServiceUsage - saved : ".$product->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../product_services.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../product_services.php");
  }
}

if (isset($_POST['update'])) {
  $product = ProductUsageServices::find_by_id($_POST['id']);
  $usage_code = implode(', ', $_POST['p_u_code']);
  $x = (explode(",",$usage_code));
  $y = (explode(",",$_POST['volume']));
  if(count($x) != count($y))
  {
    $_SESSION["error"] = "Error..! Product Used code and Volume must Match!";
    Functions::redirect_to("../product_services.php");
  }
  $product->p_use_code = $usage_code;
  if(empty($_POST['code']))
  { $_SESSION["error"] = "Error..! Code Should not be empty."; Functions::redirect_to("../product_services.php"); }
  else{
    $checkP_Code = Service::find_by_code($_POST["code"]);
    if(empty($checkP_Code))
    {
      $_SESSION["error"] = "Error..! Service code does not exist in the database. Please Try again!";
      Functions::redirect_to("../product_services.php");
    }
    else{
        $product->p_code = trim($_POST['code']);
    }
  }
  
  $product->volume = trim($_POST['volume']);
  try {
    $product->save();
    Activity::log_action("ServiceUsage - updated : ".$product->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../product_services.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../product_services.php");
  }
}

if (isset($_POST['delete'])) {
  $product = ProductUsageServices::find_by_id($_POST["id"]);
  try {
    $product->delete();
    Activity::log_action("ServiceUsage - deleted : ".$product->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../product_services.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../product_services.php");
  }
}
?>
