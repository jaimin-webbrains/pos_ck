<?php include './common/upper_content.php';?><!-- upper content -->
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
                        <a href="purchase_order.php" target="_blank"><button id="btnNew" type="button" class="btn btn-round btn-primary"><i class="glyphicon glyphicon-plus"></i> Add New</button></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>PO Code</th>
                                    <th>Date</th>
                                    <th>Username</th>
                                    <th class="col-md-2 col-sm-2 col-xs-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>165465</td>
                                    <td>24/04/2017</td>
                                    <td>Otto</td>
                                    <td>
                                        <a href="purchase_order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8446</td>
                                    <td>24/04/2017</td>
                                    <td>Thornton</td>
                                    <td>
                                        <a href="purchase_order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>878825</td>
                                    <td>24/04/2017</td>
                                    <td>the Bird</td>
                                    <td>
                                        <a href="purchase_order.php" target="_blank"><button type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-edit"></i> Edit</button></a>
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
<?php include './common/bottom_content.php';?><!-- bottom content -->
<script>
   
    if ($('#graph_bar').length){
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