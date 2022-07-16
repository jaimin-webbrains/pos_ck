<?php

require_once './../../util/initialize.php';

// check designation contact
if(isset($_REQUEST['designation'])){
    $role = $_REQUEST['designation'];

    $obj = Designation::role_name($role);
    if(!empty($obj)){
        foreach ($obj as $name) {
            echo "<b style='color:orange;'>".$name->name."</b> | ";
        }
    }else{
        echo "<p style='color:green;'> - YES GOOD TO GO WITH DESIGNATION NAME - </p>";
    }
}

// check user contact
if(isset($_REQUEST['role'])){
    $role = $_REQUEST['role'];

    $obj = Role::role_name($role);
    if(!empty($obj)){
        foreach ($obj as $name) {
            echo "<b style='color:orange;'>".$name->name."</b> | ";
        }
    }else{
        echo "<p style='color:green;'> - YES GOOD TO GO WITH ROLE NAME - </p>";
    }

}

// check user contact
if(isset($_REQUEST['user_contact'])){
    $check_customer_contact = $_REQUEST['user_contact'];

    if( strlen($check_customer_contact) > 4 ){
    $obj = User::check_contact($check_customer_contact);
    if(!empty($obj)){
        foreach ($obj as $mobile) {
            echo "<b style='color:orange;'>".$mobile->mobile."</b> | ";
        }
    }else{
        echo "<p style='color:green;'> - YES GOOD TO GO WITH THAT CONTCT NUMBER - </p>";
    }
  }

}

// check user email
if(isset($_REQUEST['user_email'])){
    $check_customer_email = $_REQUEST['user_email'];
    if( strlen($check_customer_email) > 2 ){
    $obj = User::check_email($check_customer_email);
    if(!empty($obj)){
        foreach ($obj as $email) {
            echo "<b style='color:orange;'>".$email->email."</b> | ";
        }
    }else{
        echo "<p style='color:green;'> - YES GOOD TO GO WITH THAT EMAIL ADDRESS - </p>";
    }
  }

}

// check customer contact
if(isset($_REQUEST['customer_contact'])){
    $check_customer_contact = $_REQUEST['customer_contact'];

    if( strlen($check_customer_contact) > 4 ){
    $obj = Customer::check_contact($check_customer_contact);
    if(!empty($obj)){
        foreach ($obj as $mobile) {
            echo "<b style='color:orange;'>".$mobile->mobile."</b> | ";
        }
    }else{
        echo "<p style='color:green;'> - YES GOOD TO GO WITH THAT CONTCT NUMBER - </p>";
    }
  }

}


// check customer email
if(isset($_REQUEST['customer_email'])){
    $check_customer_email = $_REQUEST['customer_email'];
    if( strlen($check_customer_email) > 2 ){
    $obj = Customer::check_email($check_customer_email);
    if(!empty($obj)){
        foreach ($obj as $email) {
            echo "<b style='color:orange;'>".$email->email."</b> | ";
        }
    }else{
        echo "<p style='color:green;'> - YES GOOD TO GO WITH THAT EMAIL ADDRESS - </p>";
    }
  }


}

// check product code
if(isset($_REQUEST['check_product_code'])){
    $check_product_code = $_REQUEST['check_product_code'];
    $obj = Product::check_code($check_product_code);

    if (!empty($obj)) {
        foreach ($obj as $codes) {
            echo "<b style='color:orange;'>".$codes->code."</b> | ";
        }
    } else{
        echo "<p style='color:green;'> - YES GOOD TO GO WITH THAT CODE - </p>";
    }
}

// check product code
if(isset($_POST['product_code'])) {
    $check_product_code = $_POST['product_code'];
    $obj = Product::check_code($check_product_code);

    if(!empty($obj) && count($obj) == 1) {
        $return['success'] = true;
        $return['code'] = $check_product_code;
        echo json_encode($return);        
    } else {
        $return['success'] = false;
        $return['code'] = $check_product_code;
        echo json_encode($return);
    }
}

// check service code
if(isset($_REQUEST['check_service_code'])){
    $check_service_code = $_REQUEST['check_service_code'];
    $obj = Service::check_code($check_service_code);

    if(!empty($obj) && count($obj) == 1) {
        $return['success'] = true;
        $return['code'] = $check_service_code;
        echo json_encode($return);        
    } else {
        $return['success'] = false;
        $return['code'] = $check_service_code;
        echo json_encode($return);
    }
}

// check the package code
if(isset($_REQUEST['check_package_code'])){
    $check_product_code = $_REQUEST['check_package_code'];
    $obj = Package::check_code($check_product_code);

    if(!empty($obj)){
        foreach ($obj as $codes) {
            echo "<b style='color:orange;'>".$codes->code."</b> | ";
        }
    } else{
        echo "<p style='color:green;'> - YES GOOD TO GO WITH THAT CODE - </p>";
    }

}
// check the colour
if(isset($_REQUEST['check_colour_code'])){
    $check_colour_code = $_REQUEST['check_colour_code'];
    $obj = ColourTube::check_code($check_colour_code);

    if(empty($obj)) {
        $return['success'] = true;
        $return['code'] = $check_colour_code;
        echo json_encode($return);        
    } else {
        $return['success'] = false;
        $return['code'] = $check_colour_code;
        echo json_encode($return);
    }
}
