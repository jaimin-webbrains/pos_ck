<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    // echo '<pre>';
    // print_r($_POST['product']);
    // die;
  foreach($_POST['product'] as $row_product){
    $stock_product_sales = new StockProductSales();
  
    if(empty($row_product['branch'])) { 
      $_SESSION["error"] = "Error..! Branch Should not be empty."; 
      Functions::redirect_to("../stock_product_sales.php"); 
    } else{ 
      $stock_product_sales->branch_id = trim($row_product['branch']); 
    }
  
    if(empty($row_product['code'])) { 
      $_SESSION["error"] = "Error..! Code Should not be empty."; 
      Functions::redirect_to("../stock_product_sales.php"); 
    } else{ 
      $stock_product_sales->p_code = trim($row_product['code']); 
    }

    if(empty($row_product['barcode'])) { 
      $_SESSION["error"] = "Error..! barcode Should not be empty."; 
      Functions::redirect_to("../stock_product_sales.php"); 
    } else{ 
      $stock_product_sales->p_code = trim($row_product['code']); 
    }

    if(empty($row_product['quantity'])) { 
      $_SESSION["error"] = "Error..! quantity Should not be empty."; 
      Functions::redirect_to("../stock_product_sales.php"); 
    } else{ 
      $stock_product_sales->p_code = trim($row_product['code']); 
    }

    if(empty($row_product['datetime'])) { 
      $_SESSION["error"] = "Error..! datetime Should not be empty."; 
      Functions::redirect_to("../stock_product_sales.php"); 
    } else{ 
      $stock_product_sales->p_code = trim($row_product['code']); 
    }
  
    $stock_product_sales->barcode = trim($row_product['barcode']);
    $stock_product_sales->quantity = trim($row_product['quantity']);
    $stock_product_sales->datetime = trim($row_product['datetime']);
    $stock_product_sales->save();
  } 
  
  try {
    // $stock_product_sales->save();
    Activity::log_action("StockProductSales - saved : ".$stock_product_sales->p_code);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../stock_product_sales.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../stock_product_sales.php");
  }
  
}

if (isset($_POST['update'])) {
  
  foreach($_POST['product'] as $row_product){
    $stock_product_sales = StockProductSales::find_by_id($_POST['id']);
    $stock_product_sales->p_code = trim($row_product['code']);
    $stock_product_sales->branch_id = trim($row_product['branch']);
    $stock_product_sales->barcode = trim($row_product['barcode']);
    $stock_product_sales->quantity = trim($row_product['quantity']);
    $stock_product_sales->datetime = trim($row_product['datetime']);
    $stock_product_sales->save();
  }
  
  try {
    // $stock_product_sales->save();
    Activity::log_action("StockProductSales - updated : ".$stock_product_sales->p_code);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../stock_product_sales.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../stock_product_sales.php");
  }
}

if (isset($_POST['delete'])) {
  $stock_product_sales = StockProductSales::find_by_id($_POST["id"]);
  try {
    $stock_product_sales->delete();
    Activity::log_action("StockProductSales - deleted : ".$stock_product_sales->p_code);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../stock_product_sales.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../stock_product_sales.php");
  }
}
?>
