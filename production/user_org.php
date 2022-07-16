<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';

if (isset($_POST["id"]) && $user = User::find_by_id($_POST["id"])) {
    $user_old_password = $user->password;
} else {
    $user = new User();
}
?>

<!--page content-->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>User</h3>
            </div>

            <div class="title_right">

            </div>
        </div>

        <div class="clearfix"></div>

        <?php Functions::output_result(); ?>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="title"><?php echo (empty($user->id)) ? 'Add' : 'Edit'; ?> User</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="form" action="proccess/user_proccess.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                            <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $user->id; ?>" />
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" placeholder="Full Name" id="txtName" name="name" value="<?php echo $user->name; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="txtDOB" name="dob" value="<?php echo $user->dob; ?>">
                                </div>
                                <div class="form-group">
                                    <label>NRIC</label>
                                    <input type="text" class="form-control" placeholder="NRIC" id="txtNIC" name="nic" value="<?php echo $user->nic; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" placeholder="Contact Number" id="txtContactNo" name="contact_no" onkeyup="showHint(this.value)" value="<?php echo $user->contact_no; ?>" autocomplete="off">
                                    <span id="txtHint"></span>
                                </div>
                                <div class="form-group">
                                    <label>e-mail</label>
                                    <input type="text" class="form-control" placeholder="e-mail" id="txtEmail" name="email" onkeyup="showHintTwo(this.value)" value="<?php echo $user->email; ?>">
                                    <span id="txtHint2"></span>
                                </div>
                                <div class="form-group">
                                    <label>Designation</label>
                                    <select class="form-control" id="cmbDesignation" name="designation_id">
                                        <option disabled="" value="0">Select Designation</option>
                                        <?php
                                        foreach (Designation::find_all() as $designaton) {
                                            if ($designaton->id == $user->designation_id) {
                                                ?>
                                                <option selected="" value="<?php echo $designaton->id; ?>"><?php echo $designaton->name; ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $designaton->id; ?>"><?php echo $designaton->name; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" placeholder="Address" id="txaAddress" name="address"><?php echo $user->address; ?></textarea>
                                </div>

                                   <div class="form-group">
                                    <label>Branch</label>
                                    <select class="form-control" name="branch">
                                    <?php
                                         foreach (Branch::find_all() as $status_data ) {
                                         echo "<option value='".$status_data->id."'>".$status_data->name."</option>";
                                         }

                                    ?>

                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" placeholder="Username" id="txtUsername" name="username" value="<?php echo $user->username; ?>">
                                </div>

                                <div id="divPassword">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Password" id="txtPassword" name="password" autocomplete="none">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm Password" id="txtConfirmPasword" name="c_password" autocomplete="none">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Roles</label>
                                    <?php
                                    $roles = [];
                                    if (isset($user->id)) {
                                        $user_roles = UserRole::find_all_by_user_id($user->id);
                                        foreach ($user_roles as $user_role) {
                                            $roles[] = $user_role->role_id;
                                        }
                                    }


                                    foreach (Role::find_all() as $role) {
                                        if (in_array($role->id, $roles)) {
                                            ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked="" class="flat" value="<?php echo $role->id; ?>" name="chbRoles[]" > <?php echo $role->name; ?>
                                                </label>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="flat" value="<?php echo $role->id; ?>" name="chbRoles[]" > <?php echo $role->name; ?>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="form-group">
                                    <div id="divImage" class="col-md-2">
                                        <?php
                                        $image = "images/user.png";
                                        if ($user->image) {
                                            $image = "uploads/users/" . $user->image;
                                        }
                                        ?>
                                        <img id="imgImage" src="<?php echo $image; ?>" alt=":( image not found..!" class="image img-responsive img-thumbnail">
                                    </div>
                                    <div class="col-md-10">
                                        <label>Image</label>
                                        <input id="inpFile" type="file" name="files_to_upload" />
                                    </div>
                                    <!--                                    <div class="col-md-10">
                                                                            <button id="btnClearImage" type="button" class="btn btn-block btn-default"><i class="fa fa-close"></i> Clear</button>
                                                                        </div>-->
                                </div>

                                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                                    <div class=" col-md-4 col-sm-4 col-xs-12">
                                        <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                                    </div>
                                    <div class=" col-md-4 col-sm-4 col-xs-12" style="display: <?php echo ($user->id) ? 'initial' : 'none'; ?>">
                                        <button id="btnDelete" type="button" name="delete" class="btn btn-block btn-danger" ><i class="fa fa-trash"></i> Delete</button>
                                    </div>
                                    <div class=" col-md-4 col-sm-4 col-xs-12">
                                        <a href="user.php"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/page content-->
<?php include 'common/bottom_content.php'; ?>
<script>

// exsisting check start
function showHint(str) {
  if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "proccess/data_check.php?user_contact=" + str, true);
    xmlhttp.send();
  }
}
// existing check ends

// exsisting check start
function showHintTwo(str) {
  if (str.length == 0) {
    document.getElementById("txtHint2").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint2").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "proccess/data_check.php?user_email=" + str, true);
    xmlhttp.send();
  }
}
// existing check ends

    window.onload = function () {
//        $.alert({
//            type: 'red',
//            title: 'Welcome!',
//            content: 'Mahesh!'
//        });
    };

    function readURL(element) {
        if (element.files && element.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(element.files[0]);
        } else {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgImage').attr('src', e.target.result);
            }
            reader.readAsDataURL("images/user.png");
        }
    }

    $("#inpFile").change(function () {
        readURL(this);
    });

    $("#btnClearImage").click(function () {
        $("#inpFile").val(null);
        readURL(this);
    });

    $(function () {
        $("#txtDOB").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });





    function encrypt_string(string) {
        var encrypted_value;
        var jc;
        $.ajax({
            type: 'POST',
            url: "proccess/user_proccess.php",
            data: {encrypt: true, string: string},
            dataType: 'json',
            async: false,
//            beforeSend: function () {
//                jc = $.dialog({
////                    closeIcon: true,
//                    icon: 'fa fa-spinner fa-spin',
//                    title: 'Working on :)',
//                    content: 'Sit back and relax, we are processing some data..!'
//                });
//            },
//            complete: function () {
//                jc.$title="aaaaaaaaaa";
//            },
            success: function (data) {
                encrypted_value = data;
            }
        });
        return encrypted_value;
    }

    function getPasswordErrors() {
        var errors = new Array();

        var element;
        var element_value;

        element = $("#txtPassword");
        element_value = element.val();
        if (element_value === "" && !(new RegExp("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/").test(element_value))) {
            errors.push("Password - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            element.css({"border": "1px solid #ccc"});
        }

        element = $("#txtConfirmPasword");
        element_value = element.val();
        if (element_value === "") {
            errors.push("Confirm Pasword - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            element.css({"border": "1px solid #ccc"});
        }

        if (errors === undefined || errors.length === 0) {
            var password = $("#txtPassword").val();
            var c_password = $("#txtConfirmPasword").val();

            if (password === c_password) {
                $("#txtPassword").css({"border": "1px solid #ccc"});
                $("#txtConfirmPasword").css({"border": "1px solid #ccc"});
            } else {
                errors.push("New password and confirm password does not match");
                $("#txtPassword").css({"border": "1px solid red"});
                $("#txtConfirmPasword").css({"border": "1px solid red"});
            }
        }

        return errors;
    }

    function checkDuplication(string) {
        var value;
        $.ajax({
            type: 'POST',
            url: "proccess/user_profile_edit_proccess.php",
            data: {findByUsername: true, string: string},
            dataType: 'json',
            async: false,
            success: function (data) {
                value = data;
            }
        });
        return value;
    }

    function getErrors() {
        var errors = new Array();
        var element;
        var element_value;

        element = $("#txtName");
        element_value = element.val();
        if (element_value === "") {
            errors.push("Name - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            element.css({"border": "1px solid #ccc"});
        }

        element = $("#txtUsername");
        element_value = element.val();
        if (element_value === "") {
            errors.push("Username - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            var username = "<?php echo $user->username; ?>";
            if (element_value === username) {
                element.css({"border": "1px solid #ccc"});
            } else {
                if (checkDuplication(element_value)) {
                    errors.push("Username - Alredy exists");
                    element.css({"border": "1px solid red"});
                } else {
                    element.css({"border": "1px solid #ccc"});
                }
            }
        }

        element = $("#txtNIC");
        element_value = element.val();
        if (element_value === "") {
            errors.push("NIC - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            element.css({"border": "1px solid #ccc"});
        }

        element = $("#txtContactNo");
        element_value = element.val();
        if (element_value === "") {
            errors.push("Contact No - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            element.css({"border": "1px solid #ccc"});
        }

        element = $("#cmbDesignation");
        element_value = element.val();
        if (element_value === "") {
            errors.push("Designation - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            element.css({"border": "1px solid #ccc"});
        }

        element = $("#txtEmail");
        element_value = element.val();
        if (element_value !== "") {
            if (Validation.valEmail(element_value)) {
                element.css({"border": "1px solid #ccc"});
            } else {
                errors.push("Email - Invalid");
                element.css({"border": "1px solid red"});
            }
        } else {
            element.css({"border": "1px solid #ccc"});
        }

        element = $("#txtDOB");
        element_value = element.val();
        if (element_value === "") {
            errors.push("Date of Birth - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            element.css({"border": "1px solid #ccc"});
        }

        element = $("#txaAddress");
        element_value = element.val();
        if (element_value === "") {
            errors.push("Address - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            element.css({"border": "1px solid #ccc"});
        }



        var user_id = "<?php echo $user->id; ?>";
        if (!user_id) {
            var passwordErrors = getPasswordErrors();
            for (i in passwordErrors) {
                errors.push(passwordErrors[i]);
            }
        }

        return errors;
    }

    function validateForm() {
        var errors = getErrors();
        if (errors === undefined || errors.length === 0) {
            return true;
        } else {
            $.alert({
                icon: 'fa fa-exclamation-circle',
                backgroundDismiss: true,
                type: 'red',
                title: 'Validation error!',
                content: errors.join("</br>")
            });
            return false;
        }
    }

    $("#btnSave").click(function () {
        var id = <?php echo ($user->id) ? 1 : 0; ?>;

        if (id) {
            if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "User", "upd")) {
                FormOperations.confirmSave(validateForm(), "#form", id, null);
            }
        } else {
            if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "User", "ins")) {
                FormOperations.confirmSave(validateForm(), "#form", id, null);
            }
        }
    });

    $("#btnDelete").click(function () {
//        alert(UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "User", "del"));
        if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "User", "del")) {
            FormOperations.confirmDelete("#form");
        }
    });

//    function confirmSave() {
//        if (validateForm()) {
//            var product_id = <?php // echo ($user->id) ? 1 : 0;  ?>;
//
//            if (product_id) {
//                $.confirm({
//                    icon: 'fa fa-question-circle',
//                    type: 'green',
//                    title: 'Save(Update)',
//                    content: 'Are you sure you want to proceed ?',
//                    buttons: {
//                        yes: {
//                            text: 'Yes',
//                            btnClass: 'btn-green',
//                            keys: ['enter'],
//                            action: function () {
//                                $("#form").append($('<input />').attr('type', 'hidden').attr('name', "update").attr('value', "true"));
//                                $("#form").submit();
//                            }
//                        },
//                        cancel: function () {
//                        }
//                    }
//                });
//            } else {
//                $.confirm({
//                    icon: 'fa fa-question-circle',
//                    type: 'green',
//                    title: 'Save',
//                    content: 'Are you sure you want to proceed ?',
//                    buttons: {
//                        yes: {
//                            text: 'Yes',
//                            btnClass: 'btn-green',
//                            keys: ['enter'],
//                            action: function () {
//                                $("#form").append($('<input />').attr('type', 'hidden').attr('name', "save").attr('value', "true"));
//                                $("#form").submit();
//                            }
//                        },
//                        cancel: function () {
//                        }
//                    }
//                });
//            }
//        }
//    }
//
//
//    function confirmDelete() {
//        $.confirm({
//            icon: 'fa fa-warning',
//            type: 'orange',
//            title: 'Delete',
//            content: 'Are you sure you want to proceed ?',
//            buttons: {
//                yes: {
//                    text: 'Yes',
//                    btnClass: 'btn-orange',
//                    keys: ['enter'],
//                    action: function () {
//                        $("#form").append($('<input />').attr('type', 'hidden').attr('name', "delete").attr('value', "true"));
//                        $("#form").submit();
//                    }
//                },
//                cancel: function () {
//                }
//            }
//        });
//    }

</script>
