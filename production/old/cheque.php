<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modalForm">
    <div class="modal-dialog modal-form">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Cheque Management</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label>Cheque Number</label>
                        <input type="text" class="form-control" placeholder="Product Name" id="txtCostPrice">
                    </div>
                    <div class="form-group">
                        <label>Bank</label>
                        <select class="form-control" id="cmbBank">
                            <option disabled="" value="0" selected="">Select Bank</option>
                            <option value="1">Sampath</option>
                            <option value="2">BOC</option>
                            <option value="1">NSB</option>
                            <option value="1">HNB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cheque Date</label>
                        <input type="date" class="form-control" placeholder="Cheque" id="txtCostPrice">
                    </div>
                    <div class="form-group">
                        <label>Cheque Value</label>
                        <input type="text" class="form-control" placeholder="Cheque Value" id="txtCostPrice">
                    </div>
                    <div class="form-group">
                        <label>Cheque Status</label>
                        <select class="form-control" id="cmbBank">
                            <option disabled="" value="0" selected="">Select Status</option>
                            <option value="1">Pending</option>
                            <option value="2">Approved</option>
                            <option value="3">Verified</option>
                        </select>
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
                <h3>Cheque management</h3>
            </div>

            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <label>Cheque management</label>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Cheque Name</th>
                                    <th>Cheque Number</th>
                                    <th>Bank</th>
                                    <th>Cheque Date</th>
                                    <th>Cheque Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a target="__blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
                                </tr>
                                
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td>T.M.S.Perera</td>
                                    <td>540654606546</td>
                                    <td>Sampath Bank</td>
                                    <td>25/06/2017</td>
                                    <td>15500.00</td>
                                    <td><button type="button" class="btn btn-primary btn-sm" onclick="fillForm(this);" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></td>
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