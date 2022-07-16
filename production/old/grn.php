<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Goods Revieved Note</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Select Purchase Order</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="form-group">
                                <select class="form-control" id="input2" >
                                    <option disabled="" value="0">Select Purchase Order</option>
                                    <option value="1">Purchase Order one</option>
                                    <option value="2">Purchase Order two</option>
                                    <option value="3">Purchase Order three</option>
                                    <option value="4">Purchase Order four</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Product</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Select Products</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="form-group col-md-4 col-sm-4 col-xs-12 ">
                                        <label>Product</label>
                                        <!--<input type="text" class="form-control" placeholder="Search by Product Code" id="txtProduct">-->
                                        <select class="form-control" id="cmbProducts">
                                            <option disabled="" value="0" selected="">Select Product</option>
                                            <option value="1">Product One</option>
                                            <option value="2">Product Two</option>
                                            <option value="3">Product Three</option>
                                            <option value="4">Product Four</option>
                                            <option value="5">Product Five</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-4 col-xs-12 ">
                                        <label>Batch</label>
                                        <!--<input type="text" class="form-control" placeholder="Search by Product Code" id="txtProduct">-->
                                        <select class="form-control" id="cmbBatch">
                                            <option disabled="" value="0" selected="">Select Batch</option>
                                            <option value="1">New Batch</option>
                                            <option value="2">Batch Two</option>
                                            <option value="3">Batch Three</option>
                                            <option value="4">Batch Four</option>
                                            <option value="5">Batch Five</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                        <label>Quantity</label>
                                        <input type="number" id="qty" name="number" required="required" min="1" max="5000" data-validate-minmax="1,5000" class="form-control col-md-7 col-xs-12">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="container-fluid divBack">
                                            <div class="form-group col-md-8 col-sm-8 col-xs-12">
                                                <label class="x_title washed" style="display: block;"><small>Product</small></label>
                                                <h4><strong id="lblProduct">Select Product...</strong></h4>
                                            </div>
                                            <div class="form-group col-md-2 col-sm-2 col-xs-6">
                                                <label class="x_title washed" style="display: block;"><small>Price</small></label>
                                                <h4><strong id="lblPrice"></strong></h4>
                                            </div>
                                            <div class="form-group col-md-2 col-sm-2 col-xs-6">
                                                <label class="x_title washed" style="display: block;"><small>Currunt Price</small></label>
                                                <h4><strong id="lblCurruntPrice"></strong></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12" id="divNewBatch">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>New Batch</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="col-md-6 col-sm-6 col-xs-12" >
                                        <div class="form-group">
                                            <label>Batch Code</label>
                                            <input type="text" class="form-control" placeholder="Batch Code" id="txtBatchCode">
                                        </div>
                                        <div class="form-group">
                                            <label>Manufacure Date</label>
                                            <input type="text" class="form-control" placeholder="Manufacure Date" id="txtMfd">
                                        </div>
                                        <div class="form-group">
                                            <label>Expire Date</label>
                                            <input type="text" class="form-control" placeholder="Expire Date" id="txtExp">
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12" >
                                        <div class="form-group">
                                            <label>Cost Price</label>
                                            <input type="text" class="form-control" placeholder="Product Name" id="txtCostPrice">
                                        </div>
                                        <div class="form-group">
                                            <label>Retail Price</label>
                                            <input type="text" class="form-control" placeholder="Product Name" id="txtRetailPrice">
                                        </div>
                                        <div class="form-group">
                                            <label>Whole-Sale Price</label>
                                            <input type="text" class="form-control" placeholder="Product Name" id="txtWHPrice">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-chevron-down"></i> Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>GRN Products</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Batch</th>
                                    <th>Quantity</th>
                                    <th class="col-sm-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Example Product</td>
                                    <td>055465</td>
                                    <td>5</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Example Product</td>
                                    <td>055465</td>
                                    <td>10</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Example Product</td>
                                    <td>055465</td>
                                    <td>15</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
                        <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<?php include './common/bottom_content.php'; ?><!-- bottom content -->
<script>
    window.onload = function () {
        $("#divNewBatch").css({"display": "none"});
    };
    
    if ($('#graph_bar').length) {
        Morris.Bar({
            element: 'graph_bar',
            data: [
                {device: 'iPhone 4', geekbench: 380},
                {device: 'iPhone 4S', geekbench: 655},
                {device: 'iPhone 3GS', geekbench: 275},
                {device: 'iPhone 5', geekbench: 1571},
                {device: 'iPhone 5S', geekbench: 655},
                {device: 'iPhone 6', geekbench: 2154},
                {device: 'iPhone 6 Plus', geekbench: 1144},
                {device: 'iPhone 6S', geekbench: 2371},
                {device: 'iPhone 6S Plus', geekbench: 1471},
                {device: 'Other', geekbench: 1371}
            ],
            xkey: 'device',
            ykeys: ['geekbench'],
            labels: ['Geekbench'],
            barRatio: 0.4,
            barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
            xLabelAngle: 35,
            hideHover: 'auto',
            resize: true
        });
    }

    $("#cmbBatch").change(function () {
        var batch = $("#cmbBatch").val();
        if (batch === "1") {
            $("#divNewBatch").css({"display": "initial"});
        } else {
            $("#divNewBatch").css({"display": "none"});
        }
    });
</script>