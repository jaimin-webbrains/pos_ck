<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->

<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-hidden="true" id="modalForm">
    <div class="modal-dialog modal-form">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Customer Management</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left">
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                        <div class="form-group">
                            <label>Customer Name</label>
                            <input type="text" class="form-control" placeholder="Customer Name" id="txtName">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" placeholder="City" id="txtCity">
                        </div>
                        <div class="form-group">
                            <label>District</label>
                            <select class="form-control" id="selDistrict">
                                <option disabled="" value="0">Select District</option>
                                <option value="1">Gampaha</option>
                                <option value="2">Colombo</option>
                                <option value="3">Kaluthara</option>
                                <option value="4">Rathnapura</option>
                                <option value="5">Kegalle</option>
                                <option value="6">Anuradhapura</option>
                                <option value="7">Polonnaruwa</option>
                                <option value="8">Mathara</option>
                                <option value="9">Hambanthota</option>
                                <option value="10">Trinkomalee</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" placeholder="Address" id="txtAddress"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="email" id="txtEmail">
                        </div>
                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="text" class="form-control" placeholder="Contact" id="txtContact">
                        </div>
                        <div class="form-group">
                            <label>Fax No</label>
                            <input type="text" class="form-control" placeholder="Fax" id="txtFax">
                        </div>
                        <div class="form-group">
                            <label>Route</label>
                            <select class="form-control" id="selRoute">
                                <option disabled="" value="0">Select Route</option>
                                <option value="1">Route one</option>
                                <option value="2">Route two</option>
                                <option value="3">Route three</option>
                                <option value="4">Route four</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                        <div class="x_panel">
                            <div class="x_title">
                                <label>Contact Person</label>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Name" id="txtCPName">
                                </div>
                                <div class="form-group">
                                    <label>NIC</label>
                                    <input type="text" class="form-control" placeholder="NIC" id="txtCPNIC">
                                </div>
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="text" class="form-control" placeholder="Date of birth" id="txtCPDob">
                                </div>
                                <div class="form-group">
                                    <label>Contact No</label>
                                    <input type="text" class="form-control" placeholder="Contact Number" id="txtCPContact">
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12" >
                        <div class="x_panel">
                            <div class="x_title">
                                <label>Configurations</label>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="form-group">
                                    <label>Credit Limit</label>
                                    <input type="text" class="form-control" placeholder="Credit Limit" id="txtCreditLimit">
                                </div>
                                <div class="form-group">
                                    <label>Credit Period(Days)</label>
                                    <input type="text" class="form-control" placeholder="Credit Period(Days)" id="txtCreditPeriod">
                                </div>
                            </div>
                        </div>
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
                <h3>Order Management</h3>
            </div>

            <div class="title_right">

            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="order.php" target="_blank"><button id="btnNew" type="button" class="btn btn-round btn-primary" ><i class="glyphicon glyphicon-plus"></i> Add New</button></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer name</th>
                                    <th>Date</th>
                                    <th>Total Quantity</th>
                                    <th>Status</th>
                                    <th class="col-sm-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <<div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>065465</td>
                                    <td>Muditha Priyanka</td>
                                    <td>12/05/2017</td>
                                    <td>50</td>
                                    <td>Pending</td>
                                    <td>
                                        <div>
                                            <a href="order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
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
        $("#txtName").val("");
        $("#selRoute").val("0");
        $("#txtAddress").val("");
    }

    function fillForm(row) {
        $("#txtName").val("ABC Company");
        $("#selRoute").val("3");
        $("#txtAddress").val("No.56, Colombo Rd Minuwangoda.");
    }
</script>