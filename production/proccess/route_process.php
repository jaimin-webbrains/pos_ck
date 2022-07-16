<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    $route = new Route();
    $route->name = trim($_POST['name']);

    try {
        $route->save();
        Activity::log_action("Route - saved : ".$route->name);
        $_SESSION["message"] = "Successfully saved.";
        Functions::redirect_to("./../route.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        Functions::redirect_to("./../route.php");
    }
}

if (isset($_POST['update'])) {
    $route = Route::find_by_id($_POST['id']);
    $route->name = trim($_POST['name']);
   
    try {
        $route->save();
        Activity::log_action("Route - updated : ".$route->name);
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("./../route.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("./../route.php");
    }
}


if (isset($_POST['delete'])) {
    $route = Route::find_by_id($_POST["id"]);
    
    try {
        $route->delete();
        Activity::log_action("Route - deleted : ".$route->name);
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("./../route.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("./../route.php");
    }
}
?>

