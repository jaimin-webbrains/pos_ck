<?php
require_once './../util/initialize.php';

if (isset($_POST["fill_initial_data"])) {
    foreach (array("Pending", "Done", "Canceled", "Returned") as $value) {
        $obj = new ChequeStatus();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Pending", "Done") as $value) {
        $obj = new CustomerOrderStatus();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Pending", "Done", "Canceled") as $value) {
        $obj = new PaymentStatus();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Pending", "Done", "Canceled") as $value) {
        $obj = new ProductionStatus();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Pending", "Done") as $value) {
        $obj = new PurchaseOrderStatus();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Product", "Material") as $value) {
        $obj = new PurchaseOrderType();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Active", "Deactive") as $value) {
        $obj = new UserStatus();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Customer Return", "Re Stock", "Damage", "Expire") as $value) {
        $obj = new ReturnReason();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Manager", "Rep", "Driver") as $value) {
        $obj = new Designation();
        $obj->name = $value;
        $obj->save();
    }

    foreach (array("Manager", "Rep", "Driver") as $value) {
        $obj = new Role();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("Normal", "Retail") as $value) {
        $obj = new InvoiceType();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("Pending", "Done") as $value) {
        $obj = new InvoiceStatus();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("Cash", "Cheque") as $value) {
        $obj = new PaymentMethod();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("Product", "Material") as $value) {
        $obj = new GRNType();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("January", "February", "March", "April", "May", "June", "July", "August", "September", "Octomber", "November", "December") as $value) {
        $obj = new TargetMonth();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("Sampath", "Commercial", "HNB", "NSB", "BOC") as $value) {
        $obj = new Bank();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("GRN Product", "Production Product", "Returned Product") as $value) {
        $obj = new InventoryType();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("New", "Return") as $value) {
        $obj = new InvoiceCondition();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("Invoice Payment", "Customer Payment") as $value) {
        $obj = new PaymentType();
        $obj->name = $value;
        $obj->save();
    }
    
    foreach (array("User", "Privilege", "Designation", "Target", "Category", "Product", "Batch", "Material", "ProductionPlan" ,"Production", "Supplier", "Customer", "Route", "ProductPO", "MaterialPO", "ProductGRN", "MaterialGRN", "Invoice", "Payment", "Return", "Deliverer", "DelivererInventory","MaterialStock", "Inventory", "Cheque", "Role") as $value) {
        $obj = new Module();
        $obj->name = $value;
        $obj->save();
    }

    $user = new User();
    $user->name = "Mahesh Perera";
    $user->designation_id = 1;
    $user->user_status_id = 1;
    $user->username = "admin";
    $user->password = Functions::encrypt_string("admin");
    $user->dob = "1995-05-05";
    $user->contact_no = "0336665552";
    $user->email = "aaa@bbb.com";
    $user->nic = "65465465v";
    $user->address = "313/1 skjhsdkjcnbdkjcbnkdjnc";
//    $user->image = "user.png";
    $user->save();
    
    $user_role=new UserRole();
    $user_role->user_id=1;
    $user_role->role_id=1;
    $user_role->save();
    
    foreach (Module::find_all() as $module) {
        $privilege=new Privilege();
        $privilege->role_id=1;
        $privilege->module_id=$module->id;
        $privilege->view=1;
        $privilege->ins=1;
        $privilege->upd=1;
        $privilege->del=1;
        $privilege->save();
    }
    
    Functions::redirect_to("init_tableees.php?done=true");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form id="form" action="init_tableees.php" method="POST">
            <input type="text" name="fill_initial_data" hidden="" />
            <input type="button" id="btn" <?php echo (isset($_GET["done"]))?"disabled":""; ?> onclick="submitForm()" value="Fill Initial Data" />
            <br/>
             <?php echo (isset($_GET["done"]))?"Done..!":""; ?>
        </form>
        <script>
            function submitForm() {
                var result = prompt("Enter password !! the database must be empty for ths operation..!!!");
                if (result) {
                    if (result == "mahesh@mahesh") {
                        document.getElementById("form").submit();
                        document.getElementById("btn").disabled = true;
                    } else {
                        alert("Wrong Password..!");
                    }
                }
            }
        </script>
    </body>
</html>

