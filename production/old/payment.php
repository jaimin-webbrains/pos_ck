<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Payment</h3>
            </div>

            <div class="title_right">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Select Invoice <small>Select invoice to continue</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <label>Invoice</label>
                                <select class="form-control" id="input1">
                                    <option disabled="" value="0">Select Invoice</option>
                                    <option value="1">Invoice one</option>
                                    <option value="2">Invoice two</option>
                                    <option value="3">Invoice three</option>
                                    <option value="4">Invoice four</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <!--                </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">-->
                    <!--                    <div class="x_title">
                                            <h2>Invoice Details</h2>
                                            <div class="clearfix"></div>
                                        </div>-->
                    <div class="x_content divBack">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="x_title washed" style="display: block;"><i class="fa fa-file-text"></i><small> Invoice</small></label>
                                <h4><strong id="lblProduct"><a target="_blank" href="invoice_prev.php">1700358</a></strong></h4>
                            </div>
                            <div class="form-group">
                                <label class="x_title washed" style="display: block;"><i class="fa fa-user"></i><small> Customer</small></label>
                                <h4><strong id="lblProduct"><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></strong></h4>
                            </div>
                            <div class="form-group">
                                <label class="x_title washed" style="display: block;"><i class="fa fa-user"></i><small> Date & Time</small></label>
                                <h4><strong id="lblProduct">09:55 - 12/05/2017</strong></h4>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                            <div class="form-group">
                                <label class="x_title washed" style="display: block;"><i class="fa fa-user"></i><small> User</small></label>
                                <h4><strong id="lblProduct">Muditha Priyanka</strong></h4>
                            </div>
                            <div class="form-group">
                                <label class="x_title washed" style="display: block;"><i class="fa fa-user"></i><small> Amount (Rs.)</small></label>
                                <h4><strong id="lblProduct">15500.00</strong></h4>
                            </div>
                            <div class="form-group">
                                <label class="x_title washed" style="display: block;"><i class="fa fa-user"></i><small> Balance</small></label>
                                <h4><strong id="lblProduct">5000.00</strong></h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Payment Method</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <select class="form-control" id="cmbPaymentMethod">
                                <option disabled="" value="0" selected="">Select Payment Method</option>
                                <option value="1">Cash</option>
                                <option value="2">Cheque</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12" id="divCheque">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Cheque</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
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
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Payment Amount</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control" placeholder="Amount" id="txtCostPrice">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Balance</label>
                                <input type="text" class="form-control" placeholder="Balance" disabled="" id="txtCostPrice">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<?php include './common/bottom_content.php'; ?><!-- bottom content -->

<script>
    $("#cmbPaymentMethod").change(function () {
        enableCheque();
    });

    function enableCheque() {
        if ($("#cmbPaymentMethod").val() == 2) {
            $("#divCheque").css({"display": "initial"});
        } else {
            $("#divCheque").css({"display": "none"});
        }

    }
</script>
