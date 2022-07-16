<?php

require_once './../../util/initialize.php';


if (isset($_POST['save'])) {
 
    $user = new User();
    $user->name = trim($_POST['name']);
    $user->designation_id = trim($_POST['designation_id']);
    $user->user_status_id = 1;
    $user->username = trim($_POST['username']);
    $user->password = Functions::encrypt_string(trim($_POST['password']));
    $user->dob = trim($_POST['dob']);
    $user->contact_no = trim($_POST['contact_no']);
    $user->registration_number = trim($_POST['registration_number']);
    $user->email = trim($_POST['email']);
    $user->nic = trim($_POST['nic']);
    $user->address = trim($_POST['address']);
	if(isset($_POST['all_b']))
	{
			   
		 $user->branch_id = 'all';
	}
	else
	{
     $user->branch_id = implode(",",$_POST['branch']);
	}
    // print_r($user->branch_id);
	 //exit();
    global $database;
    $database->start_transaction();
    try {
        if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
            $image_upload = new ImageUpload();
            $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
            $user->image = $image_name;
        } else {
        //            $user->image = NULL;
        }

        $user->save();
        $user_id = User::last_insert_id();

        if (isset($_POST['chbRoles'])) {
            foreach ($_POST['chbRoles'] as $value) {
                $user_role = new UserRole();
                $user_role->role_id = $value;
                $user_role->user_id = $user_id;
                $user_role->save();
            }
        }

        $database->commit();
        Activity::log_action("User - saved : " . $user->name);
        $_SESSION["message"] = "Successfull.";
        Functions::redirect_to("./../user.php");
    } catch (Exception $exc) {
        $database->rollback();
        $_SESSION["error"] = "Error..! Failed to save user." . $exc;
        Functions::redirect_to("./../user.php");
    }
}

if (isset($_POST['update'])) {
    //    echo '<pre>';
    // print_r($_POST);
    // die;
    $user_id = $_POST['id'];
    $user = User::find_by_id($user_id);
    $user->name = trim($_POST['name']);
    $user->designation_id = trim($_POST['designation_id']);
    $user->user_status_id = 1;
    $user->username = trim($_POST['username']);
    $user->dob = trim($_POST['dob']);
    $user->contact_no = trim($_POST['contact_no']);
    $user->registration_number = trim($_POST['registration_number']);
    $user->email = trim($_POST['email']);
    $user->nic = trim($_POST['nic']);
    $user->address = trim($_POST['address']);
    if(isset($_POST['all_b']))
	{	   
		$user->branch_id = 'all';
	}
	else
	{
     $user->branch_id = implode(",",$_POST['branch']);
	}

    if($_POST['password'] == $_POST['c_password']){
      $user->password = Functions::encrypt_string(trim($_POST['password']));
    }

    global $database;
    $database->start_transaction();
    try {
        if (isset($_FILES["files_to_upload"]["name"]) && !empty($_FILES["files_to_upload"]["name"])) {
            $image_upload = new ImageUpload();
            $image_name = $image_upload->upload_image($_FILES["files_to_upload"], "./../uploads/users/");
            $user->image = $image_name;
        } else {
//            $user->image = NULL;
        }

        $user->save();

        foreach (UserRole::find_all_by_user_id($user_id) as $user_role) {
            $user_role->delete();
        }

        if (isset($_POST['chbRoles'])) {
            foreach ($_POST['chbRoles'] as $value) {
                $user_role = new UserRole();
                $user_role->role_id = $value;
                $user_role->user_id = $user_id;
                $user_role->save();
            }
        }

        $database->commit();
        Activity::log_action("User - updated : " . $user->name);
        $_SESSION["message"] = "Successfuly updated.";
        Functions::redirect_to("./../user_management.php");
    } catch (Exception $exc) {
        $database->rollback();
//        $_SESSION["error"] = "Image upload error. " . $upload_errors[$_FILES["files_to_upload"]["error"]];
        $_SESSION["error"] = "Error..! Failed to update user." . $exc;
        Functions::redirect_to("./../user_management.php");
    }
}


if (isset($_POST['delete'])) {
    $user = User::find_by_id($_POST["id"]);

    global $database;
    $database->start_transaction();
    try {
        foreach (UserRole::find_all_by_user_id($user->id) as $user_role) {
            $user_role->delete();
        }

        $user->delete();
        $database->commit();
        Activity::log_action("User - deleted : " . $user->name);
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("./../user_management.php");
    } catch (Exception $exc) {
        $database->rollback();
        $_SESSION["error"] = "Error..! Failed to delete.";
        Functions::redirect_to("./../user_management.php");
    }
}


if (isset($_POST["encrypt"])) {
    $value = Functions::encrypt_string($_POST["string"]);
    echo json_encode($value);
}
?>
