<?php

require_once './../../util/initialize.php';

if (isset($_POST["reloadd"])) {
    echo json_encode("aaaaaaaaaa");
}

if (isset($_POST["reload"])) {
    $role_id = $_POST["role_id"];

    $final_role_modules = array();
    $modules = Module::find_all();
    foreach ($modules as $module) {
        $role_modules = Privilege::find_all_by_role_module($role_id, $module->id);
        if ($role_modules) {
            foreach ($role_modules as $role_module) {
                $role_module->module_id = $module->id;
                $rm_array = $role_module->to_array();
                $rm_array["module_name"] = $module->name;
                $final_role_modules[] = $rm_array;
            }
        } else {
            $role_module = new Privilege();
            $role_module->role_id = $role_id;
            $role_module->module_id = $module->id;
            $role_module->view = 0;
            $role_module->ins = 0;
            $role_module->upd = 0;
            $role_module->del = 0;
            $rm_array = $role_module->to_array();
            $rm_array["module_name"] = $module->name;
            $final_role_modules[] = $rm_array;
        }
    }

    echo json_encode($final_role_modules);
}

if (isset($_POST["save"])) {
    $privileges = $_POST["tblData"];
    
    global $database;
    $database->start_transaction();
    try {
        foreach ($privileges as $privilege) {
            $role_modules = Privilege::find_all_by_role_module($privilege["role_id"], $privilege["module_id"]);

            if ($role_modules) {
                foreach ($role_modules as $role_module) {
//                $role_module->delete();
                    $role_module->role_id = $privilege["role_id"];
                    $role_module->module_id = $privilege["module_id"];
                    $role_module->view = $privilege["view"];
                    $role_module->ins = $privilege["ins"];
                    $role_module->upd = $privilege["upd"];
                    $role_module->del = $privilege["del"];
                    $role_module->save();
                }
            } else {
                $role_module = new Privilege();
                $role_module->role_id = $privilege["role_id"];
                $role_module->module_id = $privilege["module_id"];
                $role_module->view = $privilege["view"];
                $role_module->ins = $privilege["ins"];
                $role_module->upd = $privilege["upd"];
                $role_module->del = $privilege["del"];
                $role_module->save();
            }
        }
        
        $database->commit();
        Activity::log_action("Privilege - updated : for ".Role::find_by_id($privilege["role_id"])->name);
        $ar=array("message"=>"Successfully Saved !", "a"=>"bb");
        echo json_encode($ar);
    } catch (Exception $exc) {
        $database->rollback();
        echo json_encode(array("error"=>"Error saving !"));
    }
}

if (isset($_POST["redirect"])) {
    if(isset($_POST["message"])){
        $_SESSION["message"]=$_POST["message"];
        Functions::redirect_to("./../privilege_management.php");
    }
    if(isset($_POST["error"])){
        $_SESSION["error"]=$_POST["error"];
        Functions::redirect_to("./../privilege_management.php");
    }
}

?>