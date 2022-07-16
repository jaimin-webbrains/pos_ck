<?php

require_once './../../util/initialize.php';
date_default_timezone_set("Asia/Calcutta");

if (isset($_POST['save'])) {
    try {
        $service = new Position();
        $service->name = trim($_POST['name']);
        $service->category = trim($_POST['category']);
        $service->ranking = trim($_POST['ranking']);
        $service->created_at = date('Y-m-d h:i:s');
        $service->updated_at = date('Y-m-d h:i:s');
        $service->save();

        Activity::log_action("Position - saved : ".trim($_POST['name']));
        $_SESSION["message"] = "Position successfully saved.";
        Functions::redirect_to("../position.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        echo $exc;
        Functions::redirect_to("../position.php");
    }
}

if (isset($_POST['update'])) {
    echo 'yyyy';
    die;
    $service = Service::find_by_id($_POST['id']);
    //  $service->service_no = trim($_POST['service_no']);
    $service->name = trim($_POST['name']);
    $service->code = trim($_POST['code']);
    $service->price = trim($_POST['price']);
    $service->ops_1 = trim($_POST['ops_1']);
    $service->ops_2 = trim($_POST['ops_2']);
    $service->category = trim($_POST['category']);

    try {
        if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
            $image_upload = new ImageUpload();
            $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
            $service->image = $image_name;
        } else {
            // $service->image = "NULL";
        }
        $service->save();

        foreach( ServiceBranch::find_by_service_id($service->id) as $data ){
          $data->delete();
        }

        foreach(Branch::find_all() as $branch_data){
          
            if(isset($_POST[$branch_data->id])){
              $product_branch = new ServiceBranch();
              $product_branch->service_id = $service->id;
              $product_branch->branch_id = $branch_data->id;
              $product_branch->save();
            }
          
        }

        Activity::log_action("Service - updated : ".$service->name);
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("../service.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("../service.php");
    }
}


if (isset($_POST['delete'])) {
    $service = Position::find_by_id($_POST["id"]);
    try {
        $service->delete();
        Activity::log_action("Position - deleted : ".$service->name);
        $_SESSION["message"] = "Position successfully deleted.";
        Functions::redirect_to("../position.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("../position.php");
    }
}
?>
