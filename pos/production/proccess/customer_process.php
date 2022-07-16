<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    $customer = new Customer();
    $customer->full_name = trim($_POST['full_name']);
    $customer->mobile = trim($_POST['mobile']);
    $customer->email = trim($_POST['email']);
    $customer->social_link = trim($_POST['social_link']);
    $customer->dob = trim($_POST['dob']);
    
    $customer->join_date = date('Y-m-d H:i:s');
    $customer->customer_status = 2;

    $customer->password = password_hash('123456', PASSWORD_DEFAULT);

    $existingCustomer = Customer::find_by_sql(" select email from customer where email= '$customer->email' ");

    print_r($existingCustomer);

    
      if(empty($existingCustomer)){
        try {
    
            $customer->save();

            if($_POST['refered_by'] != 0){

              $customer_last_id = Customer::last_insert_id();
              $newref = new Referral();
              $newref->parent_customer = trim($_POST['refered_by']);
              $newref->child_customer = $customer_last_id;
              $newref->save();
            }

            Activity::log_action("Customer - saved : ");
            $_SESSION["message"] = "Successfully saved.";
            Functions::redirect_to("../customer.php");
      } catch (Exception $exc) {
        echo "$exc";
          $_SESSION["error"] = "Error..! Failed to save.";
        Functions::redirect_to("../customer.php");
      }

    }
    else{
      $_SESSION["error"] = "Email Already Exists";
      Functions::redirect_to("../customer.php");
    }
    

}

if (isset($_POST['saveIn'])) {
  $customer = new Customer();
  $customer->full_name = trim($_POST['full_name']);
  $customer->mobile = trim($_POST['mobile']);
  $customer->email = trim($_POST['email']);
  $customer->social_link = trim($_POST['social_link']);
  $customer->dob = trim($_POST['dob']);
  
  $customer->join_date = date('Y-m-d H:i:s');
  $customer->customer_status = 2;

  $customer->password = password_hash('123456', PASSWORD_DEFAULT);

  $existingCustomer = Customer::find_by_sql(" select email from customer where email= '$customer->email' ");

  // print_r($existingCustomer);

    if(empty($existingCustomer)){
      try {
  
          $customer->save();

          if($_POST['refered_by'] != 0){

            $customer_last_id = Customer::last_insert_id();
            $newref = new Referral();
            $newref->parent_customer = trim($_POST['refered_by']);
            $newref->child_customer = $customer_last_id;
            $newref->save();
          }

          Activity::log_action("Customer - saved : ");
          $_SESSION["message"] = "Successfully saved.";
          Functions::redirect_to("../invoice_type.php");
    } catch (Exception $exc) {
      echo "$exc";
        $_SESSION["error"] = "Error..! Failed to save.";
      Functions::redirect_to("../invoice_type.php");
    }

  }
  else{
    $_SESSION["error"] = "Email Already Exists";
    Functions::redirect_to("../invoice_type.php");
  }
  

}
