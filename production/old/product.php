<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Product</h3>
            </div>

            <div class="title_right">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Product</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" id="input1">
                                        <option disabled="" value="0">Select Category</option>
                                        <option value="1">Category one</option>
                                        <option value="2">Category two</option>
                                        <option value="3">Category three</option>
                                        <option value="4">Category four</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="txtName">
                                </div>
                                <div class="form-group">
                                    <label>Cost Price</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="txtCostPrice">
                                </div>
                                <div class="form-group">
                                    <label>Retail Price</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="txtRetailPrice">
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                                <div class="form-group">
                                    <label>Whole-Sale Price</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="txtWHPrice">
                                </div>
                                <div class="form-group">
                                    <label>Re-Order Quantity</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="txtRoq">
                                </div>
                                <div class="form-group">
                                    <label>Min Quantity</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="txtMinQty">
                                </div>
                                <div class="form-group">
                                    <label>Max Quantity</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="txtMaqQty">
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
                            <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
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