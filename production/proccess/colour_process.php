<?php

require_once './../../util/initialize.php';


if (isset($_POST['save'])) {

    $color_data = new Colour();
    $color_data->code = trim($_POST['code']);
    $color_data->description = trim($_POST['description']);
   
    try {
        if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
          $image_upload = new ImageUpload();
          $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
          $color_data->image = $image_name;
        } else {
          $color_data->image = NULL;
        }
        $color_data->save();
        $last_colour= Colour::find_max_id();
    
        foreach(Branch::find_all() as $branch_data){
    
            if(isset($_POST[$branch_data->id])){
                $colour_branch = new ColourBranch();
                $colour_branch->colour_id = $last_colour;
                $colour_branch->branch_id = $branch_data->id;
                $colour_branch->save();
            }
    
        }
    
        Activity::log_action("Colour - saved : ".$colour_branch->name);
        $_SESSION["message"] = "Successfully saved.";
        Functions::redirect_to("../colour.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        echo $exc;
        Functions::redirect_to("../colour.php");
    }
}

if (isset($_POST['update'])) {
    $color_data = Colour::find_by_id($_POST['id']);
    $color_data->code = trim($_POST['code']);
    $color_data->description = trim($_POST['description']);
   
    try {
        if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
          $image_upload = new ImageUpload();
          $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
          $color_data->image = $image_name;
        } else {
          // $product->image = "NULL";
        }
        $color_data->save();
    
        foreach( ColourBranch::find_by_colour_id($color_data->id) as $data ){
          $data->delete();
        }
    
        foreach(Branch::find_all() as $branch_data){    
            if(isset($_POST[$branch_data->id])){
              $colour_branch = new ColourBranch();
              $colour_branch->colour_id = $color_data->id;
              $colour_branch->branch_id = $branch_data->id;
              $colour_branch->save();
            }
    
        }    
        Activity::log_action("Colour - updated : ".$color_data->code);
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("../colour.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("../colour.php");
    }
}


if (isset($_POST['delete'])) {
    $color = Colour::find_by_id($_POST["id"]);

    try {
        $color->delete();
        Activity::log_action("color - deleted : ".$color->code);
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("../colour.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("../colour.php");
    }
}


if (isset($_POST["encrypt"])) {
    $value = Functions::encrypt_string($_POST["string"]);
    echo json_encode($value);
}
?>
