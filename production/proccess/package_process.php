<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {

  $s_no = 0;
  $next_id = Package::find_last_data();
  $s_no = intval($next_id->service_no);
  $s_no++;

  $package = new Package();
  $package->service_no = $s_no;
  $package->name = trim($_POST['name']);
  $package->code = trim($_POST['code']);
  $package->package_price = trim($_POST['package_price']);
  $package->expire_date = trim($_POST['expire_date']);
  $package->qty = trim($_POST['qty']);
  $package->package_sales = trim($_POST['package_sales']);
  $package->ops_1 = trim($_POST['ops_1']);
  $package->ops_2 = trim($_POST['ops_2']);
  $package->category = trim($_POST['category']);

  try {
    if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
      $image_upload = new ImageUpload();
      $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
      $package->image = $image_name;
    } else {
      $package->image = NULL;
    }
    $package->save();

    $last_package = Package::last_insert_id();

    foreach(Branch::find_all() as $branch_data){
      
        if(isset($_POST[$branch_data->id])){
          $product_branch = new PackageBranch();
          $product_branch->package_id = $last_package;
          $product_branch->branch_id = $branch_data->id;
          $product_branch->save();
        }
      
    }

    Activity::log_action("Package - saved : ".$package->name);
    $_SESSION["message"] = "Successfully saved.";
    Functions::redirect_to("../package.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to save.";
    echo $exc;
    Functions::redirect_to("../package.php");
  }
}

if (isset($_POST['update'])) {
  $package = Package::find_by_id($_POST['id']);

  $s_no = 0;
  $next_id = Package::find_last_data();
  $s_no = intval($next_id->service_no);
  $s_no++;

  $package->service_no = $s_no;
  $package->name = trim($_POST['name']);
  $package->code = trim($_POST['code']);
  $package->package_price = trim($_POST['package_price']);
  $package->expire_date = trim($_POST['expire_date']);
  $package->qty = trim($_POST['qty']);
  $package->package_sales = trim($_POST['package_sales']);
  $package->ops_1 = trim($_POST['ops_1']);
  $package->ops_2 = trim($_POST['ops_2']);
  $package->category = trim($_POST['category']);

  try {
    if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
      $image_upload = new ImageUpload();
      $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
      $package->image = $image_name;
    } else {
      //            $user->image = NULL;
    }

    foreach( PackageBranch::find_by_package_id($package->id) as $data ){
      $data->delete();
    }

    foreach(Branch::find_all() as $branch_data){
     
        if(isset($_POST[$branch_data->id])){
          $product_branch = new PackageBranch();
          $product_branch->package_id = $package->id;
          $product_branch->branch_id = $branch_data->id;
          $product_branch->save();
        }
      
    }

    $package->save();
    Activity::log_action("Package - updated : ".$package->name);
    $_SESSION["message"] = "Successfully updated.";
    Functions::redirect_to("../package.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to update.";
    Functions::redirect_to("../package.php");
  }
}


if (isset($_POST['delete'])) {

  $package = Package::find_by_id($_POST["id"]);

  print_r($package);

  try {
    $package->delete();
    Activity::log_action("Package - deleted : ".$package->name);
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../package.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../package.php");
  }
}
?>
