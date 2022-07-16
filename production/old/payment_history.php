<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->



<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Invoice Payments</h3>
            </div>

            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Payment Histroy</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Date & Time</th>
                                    <th>User</th>
                                    <th>Amount(LKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
                                </tr>
                                <tr>
                                    <td><a target="_blank" href="invoice_prev.php">1700358</a></td>
                                    <td><a target="_blank" href="customer_profile.php">ABC Holdings(pvt) ltd.</a></td>
                                    <td>09:55 - 12/05/2017</td>
                                    <td><a target="_blank" href="user_profile.php">Muditha Priyanka</a></td>
                                    <td>15500.00</td>
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