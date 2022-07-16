<?php include './common/upper_content.php'; ?><!-- upper content -->
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Purchase Order</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Purchase Order</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal form-label-left">
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
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Product</label>
                                        <select class="form-control" id="input2" >
                                            <option disabled="" value="0">Select Product</option>
                                            <option value="1">Product one</option>
                                            <option value="2">Product two</option>
                                            <option value="3">Product three</option>
                                            <option value="4">Product four</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" id="number" name="number" required="required" min="1" max="5000" data-validate-minmax="1,5000" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Action</label>
                                        <button type="button" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-chevron-down"></i> Add</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="x_title">
                        <h2>Purchase Order Products</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th class="col-sm-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>5</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>10</td>
                                    <td>
                                        <button type="button" class="btn btn-block btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Larry</td>
                                    <td>the Bird</td>
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
</script>