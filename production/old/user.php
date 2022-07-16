<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modalForm">
    <div class="modal-dialog modal-form">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add User</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" placeholder="Full Name" id="txtFullName">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" placeholder="Username" id="txtUsername">
                        </div>
                        <div class="form-group">
                            <label>NIC</label>
                            <input type="text" class="form-control" placeholder="NIC" id="txtNIC">
                        </div>
                        <div class="form-group">
                            <label>e-mail</label>
                            <input type="text" class="form-control" placeholder="e-mail" id="txtEmail">
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" class="form-control" placeholder="e-mail" id="txtContactNo">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" placeholder="Full Name" id="txaAddress"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Designation</label>
                            <select class="form-control" id="cmbDesignation">
                                <option disabled="" value="0">Select Designation</option>
                                <option value="1">Designation one</option>
                                <option value="2">Designation two</option>
                                <option value="3">Designation three</option>
                                <option value="4">Designation four</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Roles</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" checked="checked"> Agent
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" checked="checked"> Deliverer
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="flat" checked="checked"> Administrator
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="files_to_upload" placeholder="Username" id="txtImage"/>
                        </div>

<!--                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Save</button>
                            <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </div>-->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
                <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Users</h3>
            </div>

            <div class="title_right">

            </div>
        </div>
        
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <button id="btnNew" type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="glyphicon glyphicon-plus"></i> Add New</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Fill Name</th>
                                    <th>NIC</th>
                                    <th>Contact No</th>
                                    <th>e-Mail</th>
                                    <th>Address</th>
                                    <th class="col-sm-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Garrett</td>
                                    <td>654654655v</td>
                                    <td>77165165</td>
                                    <td>abcd@gmail.com</td>
                                    <td>No.230, Colombo Rd Minuwangoda.</td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                                            <a href="user_profile.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Garrett Ashton</td>
                                    <td>654654655v</td>
                                    <td>77165165</td>
                                    <td>abcd@gmail.com</td>
                                    <td>No.230, Colombo Rd Minuwangoda.</td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                                            <a href="user_profile.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ashton Cedric</td>
                                    <td>654654655v</td>
                                    <td>77165165</td>
                                    <td>abcd@gmail.com</td>
                                    <td>No.230, Colombo Rd Minuwangoda.</td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                                            <a href="user_profile.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cedric Airi</td>
                                    <td>654654655v</td>
                                    <td>77165165</td>
                                    <td>abcd@gmail.com</td>
                                    <td>No.230, Colombo Rd Minuwangoda.</td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                                            <a href="user_profile.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Airi Ashton</td>
                                    <td>654654655v</td>
                                    <td>77165165</td>
                                    <td>abcd@gmail.com</td>
                                    <td>No.230, Colombo Rd Minuwangoda.</td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                                            <a href="user_profile.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Brielle Airi</td>
                                    <td>654654655v</td>
                                    <td>77165165</td>
                                    <td>abcd@gmail.com</td>
                                    <td>No.230, Colombo Rd Minuwangoda.</td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                                            <a href="user_profile.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-new-window"></i> View</button></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
<?php include './common/bottom_content.php'; ?><!-- bottom content -->
<script>
    $("#btnNew").click(function () {
        clearForm();
    });

    function clearForm() {
        $("#input1").val("0");
        $("#input2").val("");
    }

    function fillForm(row) {
        $("#input1").val("2");
        $("#input2").val("Sample Product");
    }
</script>