<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modalForm">
    <div class="modal-dialog modal-form">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Product Management</h4>
            </div>
            <div class="modal-body">

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
                <h3>Products</h3>
            </div>

            <div class="title_right">
            </div>
        </div>
        
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="product.php" target="_blank"><button id="btnNew" type="button" class="btn btn-round btn-primary"><i class="glyphicon glyphicon-plus"></i> Add New</button></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th>Category</th>
                                    <th class="col-sm-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger</td>
                                    <td>Nixon</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Garrett</td>
                                    <td>Winters</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Ashton</td>
                                    <td>Cox</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Cedric</td>
                                    <td>Kelly</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Airi</td>
                                    <td>Satou</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Brielle</td>
                                    <td>Williamson</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Herrod</td>
                                    <td>Chandler</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Rhona</td>
                                    <td>Davidson</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Colleen</td>
                                    <td>Hurst</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Sonya</td>
                                    <td>Frost</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Jena</td>
                                    <td>Gaines</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Quinn</td>
                                    <td>Flynn</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Charde</td>
                                    <td>Marshall</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Haley</td>
                                    <td>Kennedy</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Tatyana</td>
                                    <td>Fitzpatrick</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Michael</td>
                                    <td>Silva</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Paul</td>
                                    <td>Byrd</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Gloria</td>
                                    <td>Little</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Bradley</td>
                                    <td>Greer</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Dai</td>
                                    <td>Rios</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Jenette</td>
                                    <td>Caldwell</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Yuri</td>
                                    <td>Berry</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Caesar</td>
                                    <td>Vance</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Doris</td>
                                    <td>Wilder</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
                                </tr>
                                <tr>
                                    <td>Angelica</td>
                                    <td>Ramos</td>
                                    <td><a href="product.php" target="_blank"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalForm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a></td>
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