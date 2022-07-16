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
    $customer->customer_status = trim($_POST['customer_status']);
    $customer->password = password_hash('123456', PASSWORD_DEFAULT);


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
        $_SESSION["error"] = "Error..! Failed to save.";
        Functions::redirect_to("../customer.php");
    }
    
}

if (isset($_POST['update'])) {
    $customer = Customer::find_by_id($_POST['id']);
    $customer->full_name = trim($_POST['full_name']);
    $customer->mobile = trim($_POST['mobile']);
    $customer->email = trim($_POST['email']);
    $customer->social_link = trim($_POST['social_link']);
    $customer->dob = trim($_POST['dob']);
    $customer->join_date = trim($_POST['join_date']);
    $customer->customer_status = trim($_POST['customer_status']);


    try {
        $customer->save();
        Activity::log_action("Customer - updated : ");
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("../customer.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("../customer.php");
    }
}


if (isset($_POST['delete'])) {
    $customer = Customer::find_by_id($_POST["id"]);

    try {
        $customer->delete();
        Activity::log_action("Customer - deleted : ");
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("../customers.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("../customer.php");
    }
}
?>
