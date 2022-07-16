<?php

require_once './../../util/initialize.php';

if (isset($_POST['privilege_by_module_action'])) {
    $module = $_POST['module'];
    $action = $_POST['action'];
    echo json_encode(Functions::check_privilege_by_module_action($module, $action));
}
?>

