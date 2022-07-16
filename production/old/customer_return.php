<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Customer Return Form</h3>
            </div>

            <div class="title_right">

            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Customer Return</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
                            <div class="col-md-12 col-sm-12 col-xs-12" >
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <select class="form-control" id="selCustomert">
                                        <option disabled="" value="0">Select Customer Name</option>
                                        <option value="1">DR.MATHEW</option>
                                        <option value="2">PET PARADISE</option>
                                        <option value="3">BEST CARE</option>
                                        <option value="4">RAMEEZ RANGE</option>
                                        <option value="5">DR.S KANKANAMLAGE</option>
                                        <option value="6">SHARA CHEMIST</option>
                                        <option value="7">MR. RUKSHAN</option>
                                        <option value="8">MRS. MELANI</option>
                                        <option value="9">MR. MILINDA (GAMMA)</option>
                                        <option value="10">ESHAN ROYAL CANNEL</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Batch No</label>
                                    <select class="form-control" id="selBatchNo">
                                        <option disabled="" value="0">Select Batch No</option>
                                        <option value="1">B100453</option>
                                        <option value="2">B234451</option>
                                        <option value="3">B126455</option>
                                        <option value="4">B100007</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Product</label>
                                    <select class="form-control" id="selProduct">
                                        <option disabled="" value="0">Select Product</option>
                                        <option value="1">Airi</option>
                                        <option value="2">Ashton</option>
                                        <option value="3">Brenden</option>
                                        <option value="4">Charde</option>
                                        <option value="5">Fiona</option>
                                        <option value="6">Gloria</option>
                                        <option value="7">Haley</option>
                                        <option value="8">Jena</option>
                                        <option value="9">Rhona</option>
                                        <option value="10">Tatyana</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Return QTY</label>
                                    <input type="text" class="form-control" placeholder="No of return Qty" id="txtReturnQty">
                                </div>
                                <button type="button" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-chevron-down"></i> Add </button>
                            </div>

                            <table id="tblReturnQutList" class="table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Batch No </th>
                                        <th>Product</th>
                                        <th>Return Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>B100023</td>
                                        <td>Airi</td>
                                        <td>200</td>  
                                    </tr>
                                    <tr>
                                        <td>B100453</td>
                                        <td>Airi</td>
                                        <td>200</td>  
                                    </tr>
                                    <tr>
                                        <td>B330023</td>
                                        <td>Airi</td>
                                        <td>200</td>  
                                    </tr>
                                </tbody>
                            </table>
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