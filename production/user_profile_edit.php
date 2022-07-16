<?php
require_once './../util/initialize.php';


if (isset($_POST["user_id"])) {
    if ($user = User::find_by_id($_POST["user_id"])) {
        
    } else {
        $_SESSION["error"] = "Error..! User no longer exsist for edit.";
        Functions::redirect_to("./home.php");
    }
} else {
    if (isset($_SESSION["user"]["id"])) {
        $user = User::find_by_id($_SESSION["user"]["id"]);
    } else {
        unset($_SESSION);
        Functions::redirect_to("login.php");
    }
}

//$user = User::find_by_id(7);
include 'common/upper_content.php';
?>

<!--page content--> 
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Profile Edit</h3>
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
                        <h2 id="title"><?php echo $user->name; ?> (<?php echo $user->nic; ?>)</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="form" action="proccess/user_profile_edit_proccess.php" method="post" class="form-horizontal form-label-left" >
                            <input type="hidden" class="form-control" id="txtId" name="id" value="<?php echo $user->id; ?>" />
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" placeholder="Username" id="txtUsername" name="username" value="<?php echo $user->username; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" id="txtPassword" name="password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm Password" id="txtConfirmPasword" name="c_password">
                                </div>
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" class="form-control" placeholder="Old Password" id="txtOldPasword" name="old_password">
                                </div>

                                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                                    <div class=" col-md-4 col-sm-4 col-xs-12">
                                        <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                                    </div>
                                    <div class=" col-md-4 col-sm-4 col-xs-12">
                                        <a href="javascript:window.location.reload()"><button type="button" name="reset" class="btn btn-block btn-primary"><i class="fa fa-history"></i> Reset</button></a>
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
    window.onload = function () {
//        $.alert({
//            type: 'red',
//            title: 'Welcome!',
//            content: 'Mahesh!'
//        });
    };


    function encrypt_string(string) {
        var encrypted_value;
        var jc;
        $.ajax({
            type: 'POST',
            url: "proccess/user_profile_edit_proccess.php",
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

        var user_id = "<?php echo $user->id; ?>";
        if (user_id) {
            element = $("#txtOldPasword");
            element_value = element.val();
            if (user_id && element_value === "") {
                errors.push("Old Pasword - Invalid");
                element.css({"border": "1px solid red"});
            } else {
                var user_old_password = "<?php echo $user->password; ?>";
                var enterd_old_password = encrypt_string(element_value);
//                alert(user_old_password+" - old \n"+enterd_old_password+" - old");
                if (user_old_password === enterd_old_password) {
                    $("#txtOldPasword").css({"border": "1px solid #ccc"});
                } else {
                    errors.push("Old password is incorrect");
                    $("#txtOldPasword").css({"border": "1px solid red"});
                }
            }
        }

        return errors;
    }

    function findByUsername(string) {
        var value;

        $.ajax({
            type: 'POST',
            url: "proccess/user_profile_edit_proccess.php",
            data: {findByUsername: true, username: string},
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

        element = $("#txtUsername");
        element_value = element.val();
        if (element_value === "") {
            errors.push("Username - Invalid");
            element.css({"border": "1px solid red"});
        } else {
            if (element_value === "<?php echo $user->username; ?>") {
                element.css({"border": "1px solid #ccc"});
            } else {
                if (findByUsername(element_value)) {
                    errors.push("Username - Alredy exists");
                    element.css({"border": "1px solid red"});
                } else {
                    element.css({"border": "1px solid #ccc"});
                }
            }
        }

        var passwordErrors = getPasswordErrors();
        for (i in passwordErrors) {
            errors.push(passwordErrors[i]);
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
//        confirmSave();
        FormOperations.confirmSave(validateForm(), "#form");
    });
    

    function confirmSave() {
        if (validateForm()) {

            $.confirm({
                icon: 'fa fa-question-circle',
                type: 'green',
                title: 'Save',
                content: 'Are you sure you want to proceed ?',
                buttons: {
                    yes: {
                        text: 'Yes',
                        btnClass: 'btn-green',
                        keys: ['enter'],
                        action: function () {
                            $("#form").append($('<input />').attr('type', 'hidden').attr('name', "save").attr('value', "true"));
                            $("#form").submit();
                        }
                    },
                    cancel: function () {
                    }
                }
            });

        }
    }

    function confirmSaveOri() {
        if (validateForm()) {
            var product_id = <?php echo ($user->id) ? 1 : 0; ?>;

            if (product_id) {
                $.confirm({
                    icon: 'fa fa-question-circle',
                    type: 'green',
                    title: 'Save(Update)',
                    content: 'Are you sure you want to proceed ?',
                    buttons: {
                        yes: {
                            text: 'Yes',
                            btnClass: 'btn-green',
                            keys: ['enter'],
                            action: function () {
                                $("#form").append($('<input />').attr('type', 'hidden').attr('name', "update").attr('value', "true"));
                                $("#form").submit();
                            }
                        },
                        cancel: function () {
                        }
                    }
                });
            } else {
                $.confirm({
                    icon: 'fa fa-question-circle',
                    type: 'green',
                    title: 'Save',
                    content: 'Are you sure you want to proceed ?',
                    buttons: {
                        yes: {
                            text: 'Yes',
                            btnClass: 'btn-green',
                            keys: ['enter'],
                            action: function () {
                                $("#form").append($('<input />').attr('type', 'hidden').attr('name', "save").attr('value', "true"));
                                $("#form").submit();
                            }
                        },
                        cancel: function () {
                        }
                    }
                });
            }
        }
    }

</script>