<?php
    date_default_timezone_set('Asia/Colombo');

//    defined("DS")? null : define("DS", DIRECTORY_SEPARATOR);
//    defined("SITE_ROOT")?null:define("SITE_ROOT", DS."xampp".DS."htdocs".DS."backend");
//    defined("LIB_PATH")? null : define("LIB_PATH", SITE_ROOT.DS."util");

//util
//    require_once __DIR__."/validate_login.php";
    require_once __DIR__."/config.php";
    require_once __DIR__."/project_config.php";
    require_once __DIR__."/functions.php";
    require_once __DIR__."/session.php";
    require_once __DIR__."/database.php";
    require_once __DIR__."/databaseobject.php";
    require_once __DIR__."/image_upload.php";
    require_once __DIR__."/validate.php";
    require_once __DIR__."/Pagination.php";


//class - modal
    require_once __DIR__."/../modal/User.php";
    require_once __DIR__."/../modal/UserStatus.php";
    require_once __DIR__."/../modal/Designation.php";
    require_once __DIR__."/../modal/Role.php";
    require_once __DIR__."/../modal/UserRole.php";

    require_once __DIR__."/../modal/Role.php";
    require_once __DIR__."/../modal/Module.php";
    require_once __DIR__."/../modal/Privilege.php";
    require_once __DIR__."/../modal/Activity.php";

//update code
    require_once __DIR__."/../modal/ServiceCategory.php";
    require_once __DIR__."/../modal/PackageCategory.php";
    require_once __DIR__."/../modal/Service.php";
    require_once __DIR__."/../modal/Package.php";
    require_once __DIR__."/../modal/Product.php";
    require_once __DIR__."/../modal/ProductUnit.php";
    require_once __DIR__."/../modal/ProductUnitBranch.php";
    require_once __DIR__."/../modal/ProductUsageSales.php";
    require_once __DIR__."/../modal/ProductUsageServices.php";
    require_once __DIR__."/../modal/ProductServiceBranch.php";
    require_once __DIR__."/../modal/CustomerStatus.php";
    require_once __DIR__."/../modal/Customer.php";
    require_once __DIR__."/../modal/Branch.php";
    require_once __DIR__."/../modal/Invoice.php";
    require_once __DIR__."/../modal/InvoiceSub.php";
    require_once __DIR__."/../modal/Redeem.php";
    require_once __DIR__."/../modal/Referral.php";
    require_once __DIR__."/../modal/SystemSettings.php";
    require_once __DIR__."/../modal/Queue.php";
    require_once __DIR__."/../modal/RewardPoint.php";
    require_once __DIR__."/../modal/EpaymentOperator.php";
    require_once __DIR__."/../modal/Colour.php";
    require_once __DIR__."/../modal/ColourTube.php";
    
?>
