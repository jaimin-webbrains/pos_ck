<?php
require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
  $data = new Advertisment();

  global $database;
  $database->start_transaction();
  try {
    if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
      $image_upload = new ImageUpload();
      $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/advertisment/");
      $data->content = $image_name;
    } else {
      $data->content = NULL;
    }
    $data->type = 1;
    $data->save();


    $database->commit();
    Activity::log_action("Advertisment - saved : ");
    $_SESSION["message"] = "Successfull.";
    Functions::redirect_to("./../advertisment.php");
  } catch (Exception $exc) {
    $database->rollback();
    $_SESSION["error"] = "Error..! Failed to save user." . $exc;
    echo $exc;
    Functions::redirect_to("./../advertisment.php");
  }
}

if (isset($_POST['save_video'])) {
  $data = new Advertisment();

  global $database;
  $database->start_transaction();
  try {
    if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
      move_uploaded_file($_FILES["files_to_upload"]["tmp_name"],"./../uploads/advertisment/".$_FILES["files_to_upload"]["name"]);
      $data->content = $_FILES["files_to_upload"]["name"];
    } else {
      $data->content = NULL;
    }
    $data->type = 2;
    $data->save();

    $database->commit();
    Activity::log_action("Advertisment Video- saved : ");
    $_SESSION["message"] = "Successfull.";
    Functions::redirect_to("./../advertisment.php");
  } catch (Exception $exc) {
    $database->rollback();
    $_SESSION["error"] = "Error..! Failed to save user." . $exc;
    echo $exc;
    Functions::redirect_to("./../advertisment.php");
  }
}


if (isset($_POST['delete_ad'])) {
  $role = Advertisment::find_by_id($_POST["id"]);
  unlink("./../uploads/advertisment/".$role->content);

  try {
    $role->delete();
    Activity::log_action("Advertisment - deleted : ");
    $_SESSION["message"] = "Successfully deleted.";
    Functions::redirect_to("../advertisment.php");
  } catch (Exception $exc) {
    $_SESSION["error"] = "Error..! Failed to deleted.";
    Functions::redirect_to("../advertisment.php");
  }
}
