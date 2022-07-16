<?php

require_once './../../util/initialize.php';

if (isset($_POST['save'])) {
    $branch = new NewsTicker();
    $branch->content = trim($_POST['name']);

    try {
        $branch->save();
        Activity::log_action("RSS Feed - saved : ");
        $_SESSION["message"] = "Successfully saved.";
        Functions::redirect_to("../news_feed.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to save.";
        Functions::redirect_to("../news_feed.php");
    }
}

if (isset($_POST['update'])) {
    $branch = NewsTicker::find_by_id($_POST['id']);
    $branch->content = trim($_POST['name']);

    try {
        $branch->save();
        Activity::log_action("Branch - updated : ");
        $_SESSION["message"] = "Successfully updated.";
        Functions::redirect_to("../news_feed.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to update.";
        Functions::redirect_to("../news_feed.php");
    }
}


if (isset($_POST['delete'])) {

    $branch = NewsTicker::find_by_id($_POST["id"]);

    print_r($branch);

    try {
        $branch->delete();
        Activity::log_action("Branch - deleted : ");
        $_SESSION["message"] = "Successfully deleted.";
        Functions::redirect_to("../news_feed.php");
    } catch (Exception $exc) {
        $_SESSION["error"] = "Error..! Failed to deleted.";
        Functions::redirect_to("../news_feed.php");
    }
}
?>
