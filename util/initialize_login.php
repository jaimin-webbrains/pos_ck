<?php
//    defined("DS")? null : define("DS", DIRECTORY_SEPARATOR);
//    defined("SITE_ROOT")?null:define("SITE_ROOT", DS."xampp".DS."htdocs".DS."backend");
//    defined("LIB_PATH")? null : define("LIB_PATH", SITE_ROOT.DS."util");

//util    
    require_once "config.php";
    require_once "functions.php";
    require_once "session.php";
    require_once "database.php";
    require_once "databaseobject.php";
    require_once "image_upload.php";
    
//classes
    require_once "/../modal/User.php";
    require_once '/../modal/UserStatus.php';
    
    
?>
