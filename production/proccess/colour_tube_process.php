<?php

require_once './../../util/initialize.php';


if (isset($_POST['save'])) {

    $color_data = new ColourTube();
    $color_data->code = trim($_POST['code']);
    $color_data->description = trim($_POST['description']);
    $color_data->unit = trim($_POST['unit']);
    $color_data->capacity = trim($_POST['capacity']);
    try {
        
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
    
        Activity::log_action("ColourTube - saved : ".$colour_branch->name);
        $_SESSION["message"] = "Successfully saved.";
        Functions::redirect_to("../colour_tube.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        echo $exc;
        Functions::redirect_to("../colour_tube.php");
    }
}

if (isset($_POST['update'])) {
    $color_data = ColourTube::find_by_id($_POST['id']);
    $color_data->code = trim($_POST['code']);
    $color_data->description = trim($_POST['description']);
    $color_data->unit = trim($_POST['unit']);
    $color_data->capacity = trim($_POST['capacity']);
    try {
        
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
        Functions::redirect_to("../colour_tube.php");
      } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("../colour_tube.php");
      }
}


if (isset($_POST['delete'])) {
    $color = ColourTube::find_by_id($_POST["id"]);

    try {
        $color->delete();
        Activity::log_action("color - deleted : ".$color->code);
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("../colour_tube.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("../colour_tube.php");
    }
}


if (isset($_POST["encrypt"])) {
    $value = Functions::encrypt_string($_POST["string"]);
    echo json_encode($value);
}
?>
