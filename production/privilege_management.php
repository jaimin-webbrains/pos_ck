<?php
require_once './../util/initialize.php';
include 'common/upper_content.php';
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Privilage Management</h3>
            </div>

            <div class="title_right"></div>
        </div>
        <div class="clearfix"></div>

        <?php
        Functions::output_result();
        ?>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Role<small> Select role to continue</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <select class="form-control" id="cmbRole" name="role_id" required="">
                                <option disabled="" selected="">Select Role</option>
                                <?php
                                foreach (Role::find_all() as $role) {
                                    ?>
                                    <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="divPriv" class="col-md-12 col-sm-12 col-xs-12" style="display: none">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="hTitile"></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table id="tblPrivilege" class="table table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>View</th>
                                    <th>Insert</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                            <div class=" col-md-4 col-sm-4 col-xs-12"></div>
                            <div class=" col-md-4 col-sm-4 col-xs-12"></div>
                            <div class=" col-md-4 col-sm-4 col-xs-12">
                                <button id="btnSave" type="button" name="save" class="btn btn-block btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<?php include 'common/bottom_content.php'; ?><!-- bottom content -->

<script>
    window.onload = function () {
        $("#divPriv").css({"display": "none"});
    };


    $("#cmbRole").change(function (e) {
        e.preventDefault;
        fillTable();
    });

    $("#btnSave").click(function (e) {
        e.preventDefault;
        if (UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Privilege", "ins") && UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Privilege", "upd") && UserPrivileges.checkPrivilege("proccess/privileges_authenticate.php", "Privilege", "del")){
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
                            applySettings();
                        }
                    },
                    cancel: function () {
                    }
                }
            });
        }

    });

    function fillTable() {
        role_id = $("#cmbRole").val();
        role = $('#cmbRole').find('option:selected').text();

        if (role_id) {
            $("#divPriv").css({"display": "initial"});
        } else {
            $("#divPriv").css({"display": "none"});
        }

        $("#hTitile").text(role);
        $('#tblPrivilege tbody').remove();
        $.ajax({
            type: 'POST',
            url: "proccess/privilege_proccess.php",
            data: {reload: true, role_id: role_id},
            dataType: 'json',
            async: false,
            success: function (data) {

                var trHTML = "";
                $.each(data, function (index, value) {
//                    var id = data[index]["id"];
                    var id = value["id"];
                    var role_id = data[index]["role_id"];
                    var module_id = data[index]["module_id"];
                    var module_name = data[index]["module_name"];

                    var checked_view = "";
                    var bol_view = false;
                    if (data[index]["view"] == 1) {
                        bol_view = true;
                        checked_view = "checked";
                    }

                    var checked_ins = "";
                    var bol_ins = false;
                    if (data[index]["ins"] == 1) {
                        bol_ins = true;
                        checked_ins = "checked";
                    }

                    var checked_upd = "";
                    var bol_upd = false;
                    if (data[index]["upd"] == 1) {
                        bol_upd = true;
                        checked_upd = "checked";
                    }

                    var checked_del = "";
                    var bol_del = false;
                    if (data[index]["del"] == 1) {
                        bol_del = true;
                        checked_del = "checked";
                    }

                    var chbView = "<div class='checkbox'><label><input type='checkbox' class='flat' value='" + bol_view + "' " + checked_view + "> View</label></div>";
                    var chbIns = "<div class='checkbox'><label><input type='checkbox' class='flat' value='" + bol_ins + "' " + checked_ins + "> Insert</label></div>";
                    var chbUpd = "<div class='checkbox'><label><input type='checkbox' class='flat' value='" + bol_upd + "' " + checked_upd + "> Update</label></div>";
                    var chbDel = "<div class='checkbox'><label><input type='checkbox' class='flat' value='" + bol_del + "' " + checked_del + "> Delete</label></div>";
                    trHTML += "<tr id='" + module_id + "'><td>" + module_name + "</td><td>" + chbView + "</td><td>" + chbIns + "</td><td>" + chbUpd + "</td><td>" + chbDel + "</td></tr>";
                });
                $('#tblPrivilege').append(trHTML);
            }
        });
    }

    function applySettings() {
        var role_id = $("#cmbRole").val();
        var tblData = new Array();
        $('#tblPrivilege tr').each(function (row, tr) {
            tblData[row] = {
                "role_id": role_id
                , "module_id": $(tr).attr("id")
                , "view": ($(tr).find('td:eq(1)').find('input').is(":checked")) ? 1 : 0
                , "ins": ($(tr).find('td:eq(2)').find('input').is(":checked")) ? 1 : 0
                , "upd": ($(tr).find('td:eq(3)').find('input').is(":checked")) ? 1 : 0
                , "del": ($(tr).find('td:eq(4)').find('input').is(":checked")) ? 1 : 0
            };
        });
        tblData.shift();

        if (tblData !== "") {
            $.ajax({
                type: "POST",
                url: "proccess/privilege_proccess.php",
                data: {save: true, tblData: tblData},
                dataType: 'json',
                async: false,
                success: function (data) {
//                    new PNotify({
//                        title: 'Success',
//                        text: 'Successfully saved..!',
//                        type: 'success',
//                        styling: 'bootstrap3'
//                    });

//                    $.redirectPost("proccess/privilege_proccess.php", {redirect:true, message: "Successfully saved !"});
//                    location.reload(); 
//                    window.location.href="privilege_management.php?messagee=Successfully saved";

                    if (data.message) {
                        $.redirectPost("proccess/privilege_proccess.php", {redirect: true, message: data["message"]});
                    }
                    if (data.error) {
                        $.redirectPost("proccess/privilege_proccess.php", {redirect: true, error: data["error"]});
                    }

                }
            });
        } else {
            $.alert({
                icon: 'fa fa-exclamation-circle',
                backgroundDismiss: true,
                type: 'red',
                title: 'Validation error!',
                content: 'Table - Empty'
            });
        }
    }

    $.extend({
        redirectPost: function (location, args) {
            var form = $('<form>', {action: location, method: 'post'});
            $.each(args,
                    function (key, value) {
                        $(form).append(
                                $('<input>', {type: 'hidden', name: key, value: value})
                                );
                    });
            $(form).appendTo('body').submit();
        }
    });

</script>

